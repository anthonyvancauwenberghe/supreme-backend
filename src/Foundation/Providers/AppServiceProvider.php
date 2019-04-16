<?php

namespace Foundation\Providers;

use Foundation\Generator\Providers\GeneratorServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (env('APP_ENV') === 'local') {
            $this->registerLocalPackages();
        }

        if (env('APP_ENV') !== 'production') {
            $this->registerGeneratorServiceProvider();
        }
    }

    private function registerLocalPackages()
    {
        $this->app->register(\Nwidart\Modules\LaravelModulesServiceProvider::class);
        $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
    }

    private function registerGeneratorServiceProvider()
    {
        $this->app->register(GeneratorServiceProvider::class);
    }
}
