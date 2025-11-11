<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        RateLimiter::for('login', function ($request) {
            $login = (string) $request->input('login');
            return [
                Limit::perMinute(5)->by($login.'|'.$request->ip())
                    ->response(function () {
                        return back()->withErrors([
                            'login' => 'Too many attempts. Try again in a minute.',
                        ])->onlyInput('login');
                    }),
            ];
        });
    }
}
