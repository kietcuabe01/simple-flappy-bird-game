<?php

namespace App\Http\Middleware;

use App\Helper\CacheHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CheckUserIsBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $blackListIds = (array) Cache::get(CacheHelper::USER_BLACKLIST);
        if (auth()->check() && in_array(Auth::id(), $blackListIds)) {
            return \response()->json('not allow', 403);
        }
        return $next($request);
    }
}
