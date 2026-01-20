<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Models\Order;
use App\Models\OrderEvent;
use App\Models\OrderHomestay;
use App\Observers\OrderObserver;
use App\Observers\OrderEventObserver;
use App\Observers\OrderHomestayObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Order::observe(OrderObserver::class);
        OrderEvent::observe(OrderEventObserver::class);
        OrderHomestay::observe(OrderHomestayObserver::class);
    }
}
