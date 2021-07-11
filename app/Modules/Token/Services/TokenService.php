<?php

namespace App\Modules\Token\Services;

use Carbon\Carbon;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;

class TokenService
{
    protected $privateKey;

    protected $publicKey;

    protected $now;

    public function __construct()
    {
        $this->privateKey = file_get_contents(base_path('jwt_private.pem'));
        $this->publicKey = file_get_contents(base_path('jwt_public.pem'));
        $this->now = now();
    }

    public function createAccessToken(): array
    {
        $accessTokenPayload = [
            'exp' => time() + 10 * 60,
        ];
        $accessToken = JWT::encode($accessTokenPayload, $this->privateKey, 'RS256');

        return [
            'access_token' => $accessToken,
        ];
    }

    protected function getPayloadIfTokenExpired(string $accessToken): object
    {
        try {
            $payload = JWT::decode($accessToken, $this->publicKey, ['RS256']);
        } catch (ExpiredException $expiredException) {
            $base64DecodedString = base64_decode(explode('.', $accessToken)[1]);
            $payload = json_decode($base64DecodedString);
        }

        return $payload;
    }

    public function doesAccessTokenLtNowAndLt(string $accessToken, int $days): bool
    {
        $payload = $this->getPayloadIfTokenExpired($accessToken);
        $expirationDatetime = Carbon::createFromTimestamp($payload->exp);

        return (
            $expirationDatetime->lt($this->now)
            && (clone $expirationDatetime)->addDays($days)
                ->gt($this->now)
        );
    }

    public function doesAccessTokenGte(string $accessToken, int $days): bool
    {
        $payload = $this->getPayloadIfTokenExpired($accessToken);
        $expirationDatetime = Carbon::createFromTimestamp($payload->exp);

        return $this->now
            ->gte($expirationDatetime->addDays($days));
    }
}
