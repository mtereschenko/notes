<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    public const NAME_ATTRIBUTE = 'name';
    public const SURNAME_ATTRIBUTE = 'surname';
    public const PASSWORD_ATTRIBUTE = 'password';
    public const EMAIL_ATTRIBUTE = 'email';

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

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function sharedNotes(): HasManyThrough
    {
        return $this->hasManyThrough(
            Note::class,
            SharedNote::class,
            SharedNote::EMAIL_ATTRIBUTE,
            Note::SLUG_ATTRIBUTE,
            self::EMAIL_ATTRIBUTE,
            Note::SLUG_ATTRIBUTE
        );
    }

    public function getFullNameAttribute(): string
    {
        if (empty($this->attributes['full_name'])) {
            $this->attributes['full_name'] = "{$this->surname} {$this->name}";
        }

        return $this->attributes['full_name'];
    }
}
