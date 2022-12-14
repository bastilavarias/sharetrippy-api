<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $userType = $request->user()['user_type'];
        if (in_array($userType, $roles) === false) {
            return customResponse()
                ->data([])
                ->message('You do not have access to this resource')
                ->failed()
                ->generate();
        }

        return $next($request);
    }
}
