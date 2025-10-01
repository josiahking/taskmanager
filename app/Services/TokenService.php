<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\TokenRepository;

class TokenService
{
    public function generateToken(User $user): string
    {
        $existsToken = $user->tokens()->where('name', 'web')->first();
        if($existsToken){
            $existsToken->delete();
        }
        return $user->createToken('web')->plainTextToken;
    }
}