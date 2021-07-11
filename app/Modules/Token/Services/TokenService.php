<?php

namespace App\Modules\Token\Services;

use Firebase\JWT\JWT;

class TokenService
{
    public function createAccessToken(): array
    {
        $privateKey = file_get_contents(base_path('jwt_private.pem'));
        $accessTokenPayload = [
            'exp' => time() + 10 * 60,
        ];
        $accessToken = JWT::encode($accessTokenPayload, $privateKey, 'RS256');

        return [
            'access_token' => $accessToken,
        ];
    }
}
