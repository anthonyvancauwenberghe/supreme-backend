<?php

namespace Modules\License\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\License\Contracts\LicenseRepositoryContract;
use Modules\License\Contracts\LicenseServiceContract;
use Modules\License\Repositories\LicenseRepository;
use Modules\License\Services\LicenseService;

class LicenseServiceProvider extends ServiceProvider
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
            LicenseServiceContract::class,
            LicenseService::class
        );

        $this->app->bind(
            LicenseRepositoryContract::class,
            LicenseRepository::class
        );
    }
}
