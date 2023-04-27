<?php

namespace App\Repository\Implements\Login;

use App\Models\User;
use App\Repository\AcessUserRepositoryInterface;
use Exception;

class AcessRepository implements AcessUserRepositoryInterface
{
    public function login($request)
    {
        if (!$token = auth()->attempt($request)) {
            throw new Exception('Unauthorized');
        }

        return [
            'acess_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ];
    }
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
