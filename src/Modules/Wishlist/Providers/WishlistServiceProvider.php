<?php

namespace Modules\Wishlist\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Wishlist\Contracts\WishlistRepositoryContract;
use Modules\Wishlist\Contracts\WishlistServiceContract;
use Modules\Wishlist\Repositories\WishlistRepository;
use Modules\Wishlist\Services\WishlistService;

class WishlistServiceProvider extends ServiceProvider
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
            WishlistServiceContract::class,
            WishlistService::class
        );

        $this->app->bind(
            WishlistRepositoryContract::class,
            WishlistRepository::class
        );
    }
}
