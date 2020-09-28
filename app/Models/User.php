<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    const NAME_ATTRIBUTE = 'name';
    const SURNAME_ATTRIBUTE = 'surname';
    const PASSWORD_ATTRIBUTE = 'password';
    const EMAIL_ATTRIBUTE = 'email';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::NAME_ATTRIBUTE,
        self::SURNAME_ATTRIBUTE,
        self::PASSWORD_ATTRIBUTE,
        self::EMAIL_ATTRIBUTE,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
}