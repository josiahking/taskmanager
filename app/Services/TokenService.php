<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\TokenRepository;

class TokenService
{
    protected $tokenRepository;

    public function __construct(TokenRepository $tokenRepository) {
        $this->tokenRepository = $tokenRepository;
    }

    public function getUserToken(int $userId)
    {
        return $this->tokenRepository->getUserToken($userId);
    }

    public function generateToken(User $user): string
    {
        $existsToken = $user->tokens()->where('name', 'web')->first();
        if($existsToken){
            $existsToken->delete();
        }
        return $user->createToken('web')->plainTextToken;
    }
}