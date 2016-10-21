<?php
namespace NachoFassini\Auth;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->app->routesAreCached()) {
            require __DIR__ . '/../routes.php';
        }
        $this->publishes([
            __DIR__.'/../laravel-ext-auth.php' => config_path('laravel-ext-auth.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__.'/../laravel-ext-auth.php', 'laravel-ext-auth'
        );
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
        $this->loadViewsFrom(__DIR__ . '/../views', 'laravel-ext-auth');
    }
}
