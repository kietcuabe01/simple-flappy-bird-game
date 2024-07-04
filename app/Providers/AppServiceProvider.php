<?php

namespace App\Providers;

use App\Helper\FooBarHeaderHelper;
use App\Helper\UserAgentHelper;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->singleton(UserAgentHelper::class, function($app) {
            $obj = new UserAgentHelper();
            $obj->setData(resource_path('user-agents.txt'));
            return $obj;
        });

        $this->app->singleton(FooBarHeaderHelper::class, function($app) {
            $obj = new FooBarHeaderHelper();
            $obj->setData(resource_path('foobar-headers.txt'));
            return $obj;
        });

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(120)->by($request->user()?->id ?: $request->ip());
        });
    }
}
