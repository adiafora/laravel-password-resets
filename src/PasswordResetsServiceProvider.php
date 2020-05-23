<?php

namespace Adiafora\PasswordResets;

use Illuminate\Support\ServiceProvider;

class PasswordResetsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/password_resets.php' => config_path('password_resets.php'),
        ]);

        $this->loadMigrationsFrom(__DIR__.'/../migrations/');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('auth.password_resets', function()
        {
            return new \Adiafora\PasswordResets\Auth\PasswordBrokerManager($this->app);
        });
    }
}