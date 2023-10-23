<?php

namespace IBoot\Core\app\Traits;

use IBoot\Core\app\MediaCollections\FileAdder;
use IBoot\Core\app\MediaCollections\RemoteFile;
use IBoot\Core\app\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

/**
 * @method static deleted(\Closure $param)
 * @method morphMany(string $class, string $string)
 */
trait HasMedia
{
    protected array $mediaCollections = [];
    protected array $mediaManipulations = [];

    public static function bootHasMedia(): void
    {
        static::deleted(function ($model) {
            if (!in_array(SoftDeletes::class, class_uses_recursive($model))) {
                $model->media->each->delete();
            }
        });
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'model');
    }

    public function addMedia(File|UploadedFile|RemoteFile $file): FileAdder
    {
        return new FileAdder($this, $file);
    }
}
