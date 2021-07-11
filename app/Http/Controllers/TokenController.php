<?php

namespace App\Http\Controllers;

use App\Modules\Token\Services\TokenService;

class TokenController extends Controller
{
    protected $tokenService;

    public function __construct(
        TokenService $tokenService
    ) {
        $this->tokenService = $tokenService;
    }

    public function createAccessToken()
    {
        return $this->tokenService
            ->createAccessToken();
    }
}
