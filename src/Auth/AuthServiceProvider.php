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
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/../routes.php';
        }
        $this->publishes([
            __DIR__.'/../views/auth' => base_path('resources/views/auth'),
        ]);
        $this->publishes([
            __DIR__.'/../views/users' => base_path('resources/views/users'),
        ]);
        $this->publishes([
            __DIR__.'/../views/emails' => base_path('resources/views/emails'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('command.auth.table', function ($app) {
            return new AuthTableCommand;
        });
        $this->commands('command.auth.table');
    }
}
