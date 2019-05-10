<?php

namespace Modules\Settings\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Settings\Contracts\SettingsRepositoryContract;
use Modules\Settings\Contracts\SettingsServiceContract;
use Modules\Settings\Repositories\SettingsRepository;
use Modules\Settings\Services\SettingsService;

class SettingsServiceProvider extends ServiceProvider
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
            SettingsServiceContract::class,
            SettingsService::class
        );

        $this->app->bind(
            SettingsRepositoryContract::class,
            SettingsRepository::class
        );
    }
}
