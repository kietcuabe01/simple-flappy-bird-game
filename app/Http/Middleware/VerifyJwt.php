<?php

namespace App\Http\Middleware;

use App\Helper\CacheHelper;
use App\Helper\ResponseHelper;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class VerifyJwt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $userBlackList = Cache::get(CacheHelper::USER_BLACKLIST);
            if (in_array(Auth::id(), $userBlackList)) {
                return \response()->json('Forbidden', 403);
            }

            return $next($request);
        }

        throw new AuthenticationException();
    }
}
