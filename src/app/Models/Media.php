<?php

namespace IBoot\Core\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    protected $table = 'media';

    public const IS_DIRECTORY = true;
    public const IS_NOT_DIRECTORY = false;

    protected $fillable = [
        'model',
        'collection_name',
        'name',
        'disk',
        'mime_type',
        'directory',
        'parent_id',
        'is_directory',
        'size',
    ];

    protected $casts = [
        'is_directory' => 'boolean',
    ];

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Media::class, 'parent_id', 'id');
    }

    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
