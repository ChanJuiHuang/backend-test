<?php

namespace App\Http\Middleware;

use App\Modules\Token\Services\TokenService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class AccessTokenChecker
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $accessToken = $request->bearerToken();

            if (is_null($accessToken)) {
                return redirect('/');
            }

            if (Redis::exists($accessToken)) {
                return $next($request);
            }

            if (
                $request->isMethod('post')
                || $request->isMethod('put')
                || $request->isMethod('patch')
                || $request->isMethod('delete')
            ) {
                if (
                    $this->tokenService
                        ->doesAccessTokenLtNowAndLt($accessToken, 1)
                ) {
                    $newAccessToken = $this->tokenService
                        ->createAccessToken();
                    Redis::set($accessToken, '', 'EX', 60);
                    $response = $next($request);

                    return $response->header('X-New-Access-Token', $newAccessToken['access_token']);
                }

                if (
                    $this->tokenService
                        ->doesAccessTokenGte($accessToken, 1)
                ) {
                    return  redirect('/');
                }
            }

            return $next($request);
        } catch (\Exception $exception) {
            Log::error($exception);

            return redirect('/');
        }
    }
}
