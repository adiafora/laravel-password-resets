<?php

namespace Adiafora\PasswordResets\Auth;

use Illuminate\Support\Carbon;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use \Illuminate\Auth\Passwords\DatabaseTokenRepository as DatabaseTokenRepositoryParent;

class DatabaseTokenRepository extends DatabaseTokenRepositoryParent
{
    /**
     * Create a new token record.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @return string
     */
    public function create(CanResetPasswordContract $user)
    {
        $email = $user->{config('password_resets.field')};

        $this->deleteExisting($user);

        // We will create a new, random token for the user so that we can e-mail them
        // a safe link to the password reset form. Then we will insert a record in
        // the database so that we can verify the token within the actual reset.
        $token = $this->createNewToken();

        $this->getTable()->insert($this->getPayload($email, $token));

        return $token;
    }

    /**
     * Create a new token for the user.
     *
     * @return string
     */
    public function createNewToken()
    {
        return substr(parent::createNewToken(), 10, 8);
    }

    /**
     * Delete all existing reset tokens from the database.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @return int
     */
    protected function deleteExisting(CanResetPasswordContract $user)
    {
        return $this->getTable()->where(config('password_resets.field'), $user->{config('password_resets.field')})->delete();
    }

    /**
     * Build the record payload for the table.
     *
     * @param  string  $field
     * @param  string  $token
     * @return array
     */
    protected function getPayload($field, $token)
    {
        return [config('password_resets.field') => $field, 'token' => $this->hasher->make($token), 'created_at' => new Carbon];
    }

    /**
     * Determine if a token record exists and is valid.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $token
     * @return bool
     */
    public function exists(CanResetPasswordContract $user, $token)
    {
        $record = (array) $this->getTable()->where(
            config('password_resets.field'), $user->{config('password_resets.field')}
        )->first();

        return $record &&
            ! $this->tokenExpired($record['created_at']) &&
            $this->hasher->check($token, $record['token']);
    }
}