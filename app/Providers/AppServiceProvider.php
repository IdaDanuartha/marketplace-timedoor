<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Observers\OrderItemObserver;
use App\Observers\OrderObserver;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Midtrans\Config as MidtransConfig;
use Illuminate\Support\Facades\Config;

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
        MidtransConfig::$serverKey = config('midtrans.server_key');
        MidtransConfig::$isProduction = config('midtrans.is_production', false);
        MidtransConfig::$isSanitized = true;
        MidtransConfig::$is3ds = true;

        OrderItem::observe(OrderItemObserver::class);
        Order::observe(OrderObserver::class);

        $timezone = setting('timezone', 'Asia/Jakarta');

        // Set timezone
        config(['app.timezone' => $timezone]);
        date_default_timezone_set($timezone);
    }
}
