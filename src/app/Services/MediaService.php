<?php

namespace IBoot\Core\App\Services;

use IBoot\Core\App\Models\Media;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class MediaService
{
    /**
     * Get list of media
     *
     * @param $id
     * @return LengthAwarePaginator
     */
    public function getMedia($id): LengthAwarePaginator
    {
        return Media::query()->where('parent_id', $id)
            ->orderBy('name', 'desc')
            ->with('children')
            ->paginate(config('core.core.media_pagination'));
    }

    /**
     * Get a media
     *
     */
    public function getAMedia($id): Model|Collection|Builder|array|null
    {
        return Media::query()->find($id);
    }

    public function newMedia($file, $image, $disk, $parentId): Model
    {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $extensions = $file->getClientOriginalExtension();
        $mimeType = $file->getMimeType();
        if (in_array($extensions, $allowedExtensions)) {
            $mimeType = 'image/webp';
        }
        return Media::query()->create([
            'name' => $file->getClientOriginalName(),
            'disk' => $disk,
            'mime_type' => $mimeType,
            'image_lg' => $image['image_lg']['file_name'],
            'image_md' => !empty($image['image_md']) ? $image['image_md']['file_name'] : '',
            'image_sm' => !empty($image['image_sm']) ? $image['image_sm']['file_name'] : '',
            'size' => collect($image)->sum('file_size'),
            'is_directory' => Media::IS_NOT_DIRECTORY,
            'parent_id' => $parentId
        ]);
    }
}
