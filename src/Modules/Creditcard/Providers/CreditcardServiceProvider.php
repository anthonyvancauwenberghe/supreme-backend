<?php

namespace Modules\Creditcard\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Creditcard\Contracts\CreditcardRepositoryContract;
use Modules\Creditcard\Contracts\CreditcardServiceContract;
use Modules\Creditcard\Repositories\CreditcardRepository;
use Modules\Creditcard\Services\CreditcardService;

class CreditcardServiceProvider extends ServiceProvider
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
                    CreditcardServiceContract::class,
                    CreditcardService::class
                );

        $this->app->bind(
            CreditcardRepositoryContract::class,
            CreditcardRepository::class
        );
    }
}
