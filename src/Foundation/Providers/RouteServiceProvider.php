<?php

namespace Foundation\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Foundation\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    public function register()
    {
        $this->map();
        parent::register();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapWebRoutes();
        $this->mapApiRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        $domain = strtolower(env('APP_URL'));
        $domain = str_replace('http://', '', $domain);
        $domain = str_replace('https://', '', $domain);
        Route::middleware('web')
            ->namespace($this->namespace)
            ->domain($domain)
            ->group(base_path('src/Foundation/Routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        $domain = strtolower(env('API_URL'));
        $domain = str_replace('http://', '', $domain);
        $domain = str_replace('https://', '', $domain);
        Route::middleware('api:noauth')
            ->namespace($this->namespace)
            ->domain($domain)
            ->group(base_path('src/Foundation/Routes/api.php'));
    }
}
