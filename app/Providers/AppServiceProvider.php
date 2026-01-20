<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Models\Event;
use App\Models\Homestay;
use App\Models\Package;
use App\Models\Order;
use App\Models\OrderEvent;
use App\Models\OrderHomestay;
use App\Observers\EventObserver;
use App\Observers\HomestayObserver;
use App\Observers\PackageObserver;
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
        Event::observe(EventObserver::class);
        Homestay::observe(HomestayObserver::class);
        Package::observe(PackageObserver::class);
    }
}
