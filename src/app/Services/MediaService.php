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

    public function newMedia($file, $fileName, $folderPath, $parentId): Model
    {
        return Media::query()->create([
            'name' => $fileName,
            'disk' => 'public',
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'is_directory' => Media::IS_NOT_DIRECTORY,
            'parent_id' => $parentId,
            'directory' => $folderPath . '/'. $fileName
        ]);
    }
}
