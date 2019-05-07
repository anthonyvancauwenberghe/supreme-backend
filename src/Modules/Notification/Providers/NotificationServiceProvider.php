<?php

namespace Modules\Notification\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Notification\Contracts\NotificationServiceContract;
use Modules\Notification\Services\NotificationService;
use Modules\User\Repositories\UserRepository;
use Modules\User\Services\UserService;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NotificationServiceContract::class, function () {
            return new NotificationService(new UserService(new UserRepository($this->app)));
        });

        $this->app->register(\LaravelFCM\FCMServiceProvider::class);
    }
}
