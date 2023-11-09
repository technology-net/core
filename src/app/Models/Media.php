<?php

namespace IBoot\Core\App\Models;

use IBoot\CMS\Models\Post;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Media extends BaseModel
{
    protected $table = 'medias';

    public const IS_DIRECTORY = true;
    public const IS_NOT_DIRECTORY = false;

    protected $guarded = [];

    protected $casts = [
        'is_directory' => 'boolean',
    ];

    protected $appends = [
        'image_thumbnail',
        'image_medium',
        'size_format',
    ];

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Media::class, 'parent_id', 'id');
    }

    /**
     * @return MorphToMany
     */
    public function posts(): MorphToMany
    {
        return $this->morphToMany(Post::class, 'media_able');
    }

    /**
     * @return Attribute
     */
    protected function imageThumbnail(): Attribute
    {
        $image = asset('core/images/icons/txt.webp');
        if (empty($this->is_directory)) {
            $mimeType = explode('/', $this->mime_type);
            if ($mimeType[1] === 'webp') {
                $image = asset('storage' . $this->image_sm);
            }
            $image = $this->getDefaultImage($mimeType[1], $image);
        }
        return new Attribute(
            get: fn () => $image,
        );
    }
    /**
     * @return Attribute
     */
    protected function imageMedium(): Attribute
    {
        $image = asset('core/images/icons/txt.webp');
        if (empty($this->is_directory)) {
            $mimeType = explode('/', $this->mime_type);
            if ($mimeType[1] === 'webp') {
                $image = asset('storage' . $this->image_md);
            }
            $image = $this->getDefaultImage($mimeType[1], $image);
        }

        return new Attribute(
            get: fn () => $image,
        );
    }
    /**
     * @return Attribute
     */
    protected function sizeFormat(): Attribute
    {
        if (empty($this->is_directory)) {
            return new Attribute(
                get: fn () => convertSize($this),
            );
        }
        return new Attribute(
            get: fn () => '',
        );
    }

    /**
     * @param $mimeType
     * @param $image
     * @return mixed
     */
    private function getDefaultImage ($mimeType, $image): mixed
    {
        if (in_array($mimeType, ['doc', 'ms-doc', 'msword', 'wordprocessingml.document'])) {
            $image = asset('core/images/icons/docs.webp');
        }
        if (in_array($mimeType, ['excel', 'vnd.ms-excel', 'x-excel', 'x-msexcel', 'spreadsheetml.sheet'])) {
            $image = asset('core/images/icons/xls.webp');
        }
        if (in_array($mimeType, ['mspowerpoint', 'powerpoint', 'vnd.ms-powerpoint', 'x-mspowerpoint', 'presentationml.presentation'])) {
            $image = asset('core/images/icons/ppt.webp');
        }
        if ($mimeType === 'pdf') {
            $image = asset('core/images/icons/pdf.webp');
        }

        return $image;
    }
}
