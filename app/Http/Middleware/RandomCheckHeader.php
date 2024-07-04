<?php

namespace App\Http\Middleware;

use App\Helper\FooBarHeaderHelper;
use App\Helper\UserAgentHelper;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RandomCheckHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var FooBarHeaderHelper $foobarHeader */
        $foobarHeader = app(FooBarHeaderHelper::class);
        if ($foobarHeader->isValid($request)) {
            return $next($request);
        }

        return response()->json('not allow');

    }
}
