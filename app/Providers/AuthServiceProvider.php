<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        \App\Models\Category::class => \App\Policies\CategoryPolicy::class,
        \App\Models\Product::class => \App\Policies\ProductPolicy::class,
        \App\Models\Order::class => \App\Policies\OrderPolicy::class,
        \App\Models\WebSetting::class => \App\Policies\WebSettingPolicy::class,
        \App\Models\Customer::class => \App\Policies\CustomerPolicy::class,
        \App\Models\Vendor::class => \App\Policies\VendorPolicy::class,
        \App\Models\CustomerAddress::class => \App\Policies\CustomerAddressPolicy::class,
    ];

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
        //
    }
}
