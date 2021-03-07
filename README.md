Laravel. Reset a user's password using any field
=====================

Laravel offers an easy way to reset a user's password. But by default, the required field for the user that identifies the user when the password is reset is the email field. This package allows you to reset a user's password using any field from the User table. This can be a phone number, username, or any other unique field from the User table.

Installation
-----------------------------------

Run:

```php
    composer require "adiafora/laravel-password-resets"
```
For Laravel < 5.5 Add in ServiceProvider to the providers array in `config/app.php`:
```php
    Adiafora\PasswordResets\PasswordResetsServiceProvider::class,
```

Publish the configuration:

```php
    php artisan vendor:publish --provider="Adiafora\PasswordResets\PasswordResetsServiceProvider"
```

In the configuration file `config/password_resets.php`, enter the name of the field that will be used to reset the password:

```php
return [
    'field' => 'login',
];
```


> Please note! You may need to clear the config cache after this.


Finally, you'll also need to run migration on the package:

```php
    php artisan migrate
````

Usage
-----------------------------------

In your ResetPasswordController, simply replace  `Illuminate\Foundation\Auth\ResetsPasswords` trait with the `Adiafora\PasswordResets\Auth\ResetsPasswords` trait.

And in your ForgotPasswordController, simply replace  `Illuminate\Foundation\Auth\SendsPasswordResetEmails` trait with the `Adiafora\PasswordResets\Auth\SendsPasswordResetEmails` trait.

License
-----------------------------------

The MIT License (MIT). Please see License File for more information.