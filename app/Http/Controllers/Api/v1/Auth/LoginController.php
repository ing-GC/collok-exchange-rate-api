<?php

namespace App\Http\Controllers\Api\v1\Auth;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        if (!Auth::attempt($request->validated())) {
            return response(
                ['message' => 'The provided credentials are incorrect.'],
                Response::HTTP_UNAUTHORIZED
            );
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->accessToken;

        return response([
            'data' => [
                'token' => $token,
                'token_type' => 'Bearer'
            ],
        ], Response::HTTP_OK);
    }
}
