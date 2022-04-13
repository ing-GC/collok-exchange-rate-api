<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Models\User;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        $user = User::create((array) $request->after());

        return response([
            'message' => 'User created successfully',
            'data' => [
                'user' => UserResource::make($user),
            ]
        ], Response::HTTP_CREATED);
    }
}
