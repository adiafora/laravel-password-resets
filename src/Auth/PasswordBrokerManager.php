<?php

namespace Adiafora\PasswordResets\Auth;

use Illuminate\Support\Str;
use \Illuminate\Auth\Passwords\PasswordBrokerManager as PasswordBrokerManagerParent;

class PasswordBrokerManager extends PasswordBrokerManagerParent
{
    /**
     * Create a token repository instance based on the given configuration.
     *
     * @param  array  $config
     * @return \Illuminate\Auth\Passwords\TokenRepositoryInterface
     */
    protected function createTokenRepository(array $config)
    {
        $key = $this->app['config']['app.key'];

        if (Str::startsWith($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }

        $connection = $config['connection'] ?? null;

        return new DatabaseTokenRepository(
            $this->app['db']->connection($connection),
            $this->app['hash'],
            $config['table'],
            $key,
            $config['expire']
        );
    }
}
