<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\PersonalAccessToken;

class TokenRepository
{
    public function getUserToken(int $id): ?string
    {
        $token = PersonalAccessToken::where('tokenable_id', $id)->first();
        return $token->token;
    }
}