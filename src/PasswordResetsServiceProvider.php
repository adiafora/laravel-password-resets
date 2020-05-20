<?php

namespace Adiafora\PasswordResets;

class PasswordResetsServiceProvider
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
        ], 'config');

        $this->publishes([
            __DIR__ . '/../migrations/' => database_path('migrations'),
        ], 'migrations');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('auth.password_my', function()
        {
            return new \Adiafora\PasswordResets\Auth\PasswordBrokerManager($this->app);
        });
    }
}