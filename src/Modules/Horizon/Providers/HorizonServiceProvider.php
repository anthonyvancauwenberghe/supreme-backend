<?php

namespace Modules\Horizon\Providers;

use Foundation\Contracts\ConditionalAutoRegistration;
use Illuminate\Support\ServiceProvider;

class HorizonServiceProvider extends ServiceProvider implements ConditionalAutoRegistration
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\Laravel\Horizon\HorizonServiceProvider::class);
    }

    public function registrationCondition(): bool
    {
        return ! app()->environment('testing');
    }
}
