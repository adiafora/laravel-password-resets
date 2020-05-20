<?php

namespace Adiafora\PasswordResets\Auth;

use Illuminate\Support\Facades\Password;

/**
 * @see \Illuminate\Auth\Passwords\PasswordBroker
 */
class PasswordFacade extends Password
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'auth.password_my';
    }
}