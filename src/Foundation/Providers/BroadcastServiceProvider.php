<?php

namespace Foundation\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes([
            'middleware' => ['api'],
            'domain'     => env('API_URL'),
        ]);

        require base_path('src/Foundation/Routes/channels.php');
    }
}
