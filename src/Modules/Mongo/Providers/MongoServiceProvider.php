<?php

namespace Modules\Mongo\Providers;

use DB;
use Illuminate\Support\ServiceProvider;

class MongoServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\Jenssegers\Mongodb\MongodbServiceProvider::class);
        $this->app->register(\Jenssegers\Mongodb\MongodbQueueServiceProvider::class);
        DB::connection('mongodb')->enableQueryLog();
    }
}
