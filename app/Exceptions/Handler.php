<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            // return your custom response
            return customResponse()
                ->data([])
                ->message('The identifier you are querying does not exist')
                ->slug('no_query_result')
                ->failed(502)
                ->generate();
        }
        if ($e instanceof AuthorizationException) {
            return customResponse()
                ->data([])
                ->message('You do not have right to access this resource')
                ->slug('forbidden_request')
                ->failed(403)
                ->generate();
        }

        if ($e instanceof QueryException) {
            return customResponse()
                ->data([])
                ->message($e->getMessage())
                ->slug('query_exception')
                ->failed(400)
                ->generate();
        }

        return parent::render($request, $e);
    }

    public function unauthenticated($request, AuthenticationException $exception)
    {
        return customResponse()
            ->data([])
            ->message('You do not have valid authentication token')
            ->slug('missing_bearer_token')
            ->failed(401)
            ->generate();
    }
}
