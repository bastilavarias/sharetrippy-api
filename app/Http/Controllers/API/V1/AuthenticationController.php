<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login(LoginRequest $request) {
        if (!Auth::attempt($request->all())) {
            return customResponse()
                ->data([])
                ->message('Invalid credentials.')
                ->unathorized()
                ->generate();
        }
        $accessToken = Auth::user()->createToken('authToken')->accessToken;
        $user = User::with('profile')->find(Auth::id());

        return customResponse()
            ->data([
                'user' => $user,
                'access_token' => $accessToken,
            ])
            ->message('You have successfully logged in.')
            ->success()
            ->generate();
    }
}
