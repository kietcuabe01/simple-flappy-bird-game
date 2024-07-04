<?php

namespace App\Http\Middleware;

use App\Helper\UserAgentHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBrowser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var UserAgentHelper $userAgentHelper */
        $userAgentHelper = app(UserAgentHelper::class);
        $userAgent = $request->header('User-Agent');

        if ($userAgent && $userAgentHelper->isValid($userAgent)) {
            return $next($request);
        }

        return response()->json('not allow');
    }
}
