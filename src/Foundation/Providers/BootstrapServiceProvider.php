<?php

namespace Foundation\Providers;

use Foundation\Console\SeedCommand;
use Foundation\Observers\CacheObserver;
use Foundation\Policies\OwnershipPolicy;
use Foundation\Services\BootstrapRegistrarService;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Route;

/**
 * Class BootstrapServiceProvider.
 */
class BootstrapServiceProvider extends ServiceProvider
{
    /**
     * @var BootstrapRegistrarService
     */
    protected $bootstrapService;

    public function boot()
    {
        /* Load cache observers only when caching is enabled */
        if (config('model.caching')) {
            $this->loadCacheObservers();
        }
    }

    public function register()
    {
        /* Load BootstrapService here because of the dependencies needed in BootstrapRegistrarService */
        $this->loadBootstrapService();

        $this->loadCommands();
        $this->loadRoutes();
        $this->loadConfigs();
        $this->loadFactories();
        $this->loadMigrations();
        $this->loadListeners();

        /* Override the seed command with the larapi custom one */
        $this->overrideSeedCommand();

        /* Register Model Policies */
        $this->loadModelPolicies();

        /* Register Model Observers */
        $this->loadModelObservers();

        /* Register all Module Service providers.
        ** Always load at the end so the user has the ability to override certain functionality
         * */
        $this->loadServiceProviders();
    }

    private function loadBootstrapService()
    {
        $this->bootstrapService = new BootstrapRegistrarService();

        if (! ($this->app->environment('production'))) {
            $this->bootstrapService->recache();
        }
    }

    private function loadCommands()
    {
        foreach ($this->bootstrapService->getCommands() as $command) {
            $this->commands($command['class']);
        }
    }

    private function loadRoutes()
    {
        $moduleModel = null;
        foreach ($this->bootstrapService->getRoutes() as $route) {
            Route::group([
                'prefix' => $route['prefix'],
                'namespace' => $route['controller_namespace'],
                'domain' => $route['domain'],
                'middleware' => ['api'],
            ], function () use ($route) {
                require $route['path'];
            });
            if ($moduleModel !== $route['module_model']) {
                Route::model(strtolower(get_short_class_name($route['module_model'])), $route['module_model']);
            }
            $moduleModel = $route['module_model'];
        }
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function loadConfigs()
    {
        foreach ($this->bootstrapService->getConfigs() as $config) {
            $this->mergeConfigFrom(
                $config['path'],
                $config['name']
            );
        }
    }

    /**
     * Register additional directories of factories.
     *
     * @return void
     */
    public function loadFactories()
    {
        foreach ($this->bootstrapService->getFactories() as $factory) {
            if (! $this->app->environment('production')) {
                app(Factory::class)->load($factory['path']);
            }
        }
    }

    /**
     * Register additional directories of migrations.
     *
     * @return void
     */
    public function loadMigrations()
    {
        foreach ($this->bootstrapService->getMigrations() as $migration) {
            $this->loadMigrationsFrom($migration['path']);
        }
    }

    private function overrideSeedCommand()
    {
        $app = $this->app;
        $service = $this->bootstrapService;
        $this->app->extend('command.seed', function () use ($app, $service) {
            return new SeedCommand($app['db'], $service);
        });
    }

    private function loadCacheObservers()
    {
        foreach ($this->bootstrapService->getModels() as $model) {
            if ($model['cacheable']) {
                $model['class']::observe(CacheObserver::class);
            }
        }
    }

    private function loadModelPolicies()
    {
        foreach ($this->bootstrapService->getModels() as $model) {
            foreach ($model['policies'] as $policy) {
                Gate::policy($model['class'], $policy);
                if ($model['ownable']) {
                    Gate::define('access', OwnershipPolicy::class.'@access');
                }
            }
        }
    }

    private function loadModelObservers()
    {
        foreach ($this->bootstrapService->getModels() as $model) {
            foreach ($model['observers'] as $observer) {
                $model['class']::observe($observer);
            }
        }
    }

    private function loadServiceProviders()
    {
        foreach ($this->bootstrapService->getProviders() as $provider) {
            $this->app->register($provider['class']);
        }
    }

    private function loadListeners()
    {
        foreach ($this->bootstrapService->getEvents() as $event) {
            foreach ($event['listeners'] as $listener) {
                Event::listen($event['class'], $listener);
            }
        }
    }
}
