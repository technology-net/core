<?php

namespace IBoot\Core\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    protected $table = 'media';

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

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function getSize(): mixed
    {
        return $this->size;
    }
}
