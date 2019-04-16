<?php

namespace Modules\Authorization\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Authorization\Contracts\AuthorizationContract;
use Modules\Authorization\Services\AuthorizationService;

class AuthorizationServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\Spatie\Permission\PermissionServiceProvider::class);

        $this->app->bind(
            AuthorizationContract::class,
            AuthorizationService::class
        );
    }
}
