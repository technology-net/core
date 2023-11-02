<?php

namespace IBoot\Core\App\Services;

use IBoot\Core\App\Models\Media;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

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
            ->orderBy('is_directory', 'desc')
            ->orderBy('created_at', 'desc')
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
        $name = $file->getClientOriginalName();
        if (in_array(strtolower($extensions), $allowedExtensions)) {
            $mimeType = 'image/webp';
            $originalName = explode('.', $name);
            $name = $originalName[0] . '.webp';
        }
        return Media::query()->create([
            'name' => $name,
            'disk' => $disk,
            'mime_type' => $mimeType,
            'image_lg' => $image['image_lg']['file_path'],
            'image_md' => !empty($image['image_md']) ? $image['image_md']['file_path'] : '',
            'image_sm' => !empty($image['image_sm']) ? $image['image_sm']['file_path'] : '',
            'size' => collect($image)->sum('file_size'),
            'is_directory' => Media::IS_NOT_DIRECTORY,
            'parent_id' => $parentId
        ]);
    }

    /**
     * @param array $inputs
     * @return null
     */
    public function makeFolder(array $inputs = array())
    {
        $name = Arr::get($inputs, 'name', '');
        $parent = Arr::get($inputs, 'parent_id', null);
        if (!empty($name)) {
            $existingFolders = Media::query()
                ->where('parent_id', $parent)
                ->where('name', 'LIKE', $name . '%')
                ->get();

            if ($existingFolders->isNotEmpty()) {
                $maxIdx = 0;
                foreach ($existingFolders as $item) {
                    if (preg_match('/\((\d+)\)$/', $item->name, $matches)) {
                        $index = (int)$matches[1];
                        if ($index > $maxIdx) {
                            $maxIdx = $index;
                        }
                    }
                }
                $name = $name . '(' . ($maxIdx + 1) . ')';
            }

            return $this->createOrUpdate(
                ['id' => 0],
                [
                    'name' => $name,
                    'parent_id' => $parent,
                    'is_directory' => Media::IS_DIRECTORY,
                ]
            );
        }

        return null;
    }

    /**
     * @param array $conditions
     * @param array $datas
     * @return Model|Builder
     */
    private function createOrUpdate(array $conditions = array(), array $datas = array()): Model|Builder
    {
        return Media::query()->updateOrCreate($conditions, $datas);
    }
}
