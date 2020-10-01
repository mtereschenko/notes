<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Note extends Model
{
    use HasSlug;

    public const PRIVATE = 1;
    public const PUBLIC = 2;

    public const ID_ATTRIBUTE = 'id';
    public const TITLE_ATTRIBUTE = 'title';
    public const PREVIEW_BODY_ATTRIBUTE = 'preview_body';
    public const BODY_ATTRIBUTE = 'body';
    public const SLUG_ATTRIBUTE = 'slug';
    public const PRIVACY_STATUS_ATTRIBUTE = 'privacy_status';
    public const USER_ID_ATTRIBUTE = 'user_id';
    public const CREATED_AT_ATTRIBUTE = 'created_at';
    public const UPDATED_AT_ATTRIBUTE = 'updated_at';

    protected $fillable = [
        self::TITLE_ATTRIBUTE,
        self::PREVIEW_BODY_ATTRIBUTE,
        self::BODY_ATTRIBUTE,
        self::SLUG_ATTRIBUTE,
        self::PRIVACY_STATUS_ATTRIBUTE,
        self::USER_ID_ATTRIBUTE,
    ];

    public function scopeSelectWithoutBody(Builder $builder) {
        $table = $this->getTable();
        $builder->select([
            $table . '.' . Note::SLUG_ATTRIBUTE,
            $table . '.' . Note::ID_ATTRIBUTE,
            $table . '.' . Note::PRIVACY_STATUS_ATTRIBUTE,
            $table . '.' . Note::CREATED_AT_ATTRIBUTE,
            $table . '.' . Note::UPDATED_AT_ATTRIBUTE,
            $table . '.' . Note::TITLE_ATTRIBUTE,
            $table . '.' . Note::PREVIEW_BODY_ATTRIBUTE,
            $table . '.' . Note::USER_ID_ATTRIBUTE,
        ]);
    }

    public function author() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom([self::ID_ATTRIBUTE, self::TITLE_ATTRIBUTE])
            ->saveSlugsTo(self::SLUG_ATTRIBUTE);
    }
}
