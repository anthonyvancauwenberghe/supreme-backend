<?php

namespace Modules\Device\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Device\Contracts\DeviceRepositoryContract;
use Modules\Device\Contracts\DeviceServiceContract;
use Modules\Device\Repositories\DeviceRepository;
use Modules\Device\Services\DeviceService;
use Modules\Device\Services\FirebaseMessagingService;

class DeviceServiceProvider extends ServiceProvider
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
            DeviceServiceContract::class,
            DeviceService::class
        );

        $this->app->bind(
            DeviceRepositoryContract::class,
            DeviceRepository::class
        );
    }
}
