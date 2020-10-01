<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SharedNote extends Model
{
    public const EMAIL_ATTRIBUTE = 'email';
    public const SLUG_ATTRIBUTE = 'slug';

    protected $fillable = [
        self::EMAIL_ATTRIBUTE,
        self::SLUG_ATTRIBUTE
    ];

    public function user()
    {
        return $this->belongsTo(User::class, User::EMAIL_ATTRIBUTE, self::EMAIL_ATTRIBUTE);
    }

    public function note()
    {
        return $this->belongsTo(Note::class, Note::SLUG_ATTRIBUTE, self::SLUG_ATTRIBUTE);
    }
}
