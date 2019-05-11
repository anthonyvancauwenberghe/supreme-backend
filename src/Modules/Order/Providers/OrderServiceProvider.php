<?php

namespace Modules\Order\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Order\Contracts\OrderRepositoryContract;
use Modules\Order\Contracts\OrderServiceContract;
use Modules\Order\Repositories\OrderRepository;
use Modules\Order\Services\OrderService;

class OrderServiceProvider extends ServiceProvider
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
            OrderServiceContract::class,
            OrderService::class
        );

        $this->app->bind(
            OrderRepositoryContract::class,
            OrderRepository::class
        );
    }
}
