<?php

namespace IBoot\Core\App\Services;

use IBoot\Core\App\Models\Media;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use IBoot\Core\App\Traits\CommonUploader;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    use CommonUploader;
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
            ->orderBy('id', 'desc')
            ->with('children')
            ->paginate(config('core.media_pagination'));
    }

    /**
     * Get a media
     *
     */
    public function getAMedia($id): Model|Collection|Builder|array|null
    {
        return Media::query()->find($id);
    }

    /**
     * @param $file
     * @param $image
     * @param $disk
     * @param $parentId
     * @param $now
     * @return Model
     */
    public function newMedia($file, $image, $disk, $parentId, $now): Model
    {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $extensions = $file->getClientOriginalExtension();
        $mimeType = $file->getMimeType();
        $name = $file->getClientOriginalName();
        $originalName = explode('.', $name)[0] . '_' . $now;
        if (in_array(strtolower($extensions), $allowedExtensions)) {
            $mimeType = 'image/webp';
        }

        return Media::query()->create([
            'name' => $originalName,
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
     * @param array $inputs
     * @return string
     */
    public function downloadFile(array $inputs = array()): string
    {
        $ids = Arr::get($inputs, 'ids', []);
        $medias = Media::query()->whereIn('id', $ids)->get();
        $disk = $this->getDisk();
        $filePath = '';

        if ($medias->isNotEmpty() && $medias->count() == 1 && !$medias[0]->is_directory) {
            $path = $this->getDirectory($medias[0]->image_lg);
            if (Storage::disk($disk)->exists($path)) {
                $filePath = Storage::disk($disk)->path($path);
            }
        } else {
            dd('chua co code');
        }

        return $filePath;
    }

    /**
     * @param array $inputs
     * @return bool
     */
    public function deleteFiles(array $inputs = array()): bool
    {
        $ids = Arr::get($inputs, 'ids', []);
        $medias = Media::query()->whereIn('id', $ids)->get();
        foreach ($medias as $media) {
            $this->deleteFolderRecursive($media);
        }

        return true;
    }

    public function renameFile(array $inputs = array())
    {
        $id = Arr::get($inputs, 'id', '');
        $name = Arr::get($inputs, 'name', '');
    }

    /**
     * @param $media
     * @return void
     */
    private function deleteFolderRecursive($media): void
    {
        $disk = $this->getDisk();
        foreach ($media->children as $child) {
            $this->deleteFolderRecursive($child);
        }
        if (empty($media->is_directory)) {
            $path = $this->getDirectory('/uploads/' . $media->name);
            if (Storage::disk($disk)->exists($path)) {
                Storage::disk($disk)->deleteDirectory($path);
            }
        }
        $media->delete();
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
