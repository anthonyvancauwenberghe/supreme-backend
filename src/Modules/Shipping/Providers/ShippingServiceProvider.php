<?php

namespace Modules\Shipping\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Shipping\Contracts\ShippingRepositoryContract;
use Modules\Shipping\Contracts\ShippingServiceContract;
use Modules\Shipping\Repositories\ShippingRepository;
use Modules\Shipping\Services\ShippingService;

class ShippingServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
       //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ShippingServiceContract::class,
            ShippingService::class
        );

        $this->app->bind(
            ShippingRepositoryContract::class,
            ShippingRepository::class
        );
    }
}
