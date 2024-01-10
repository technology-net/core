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
     * @return Model
     */
    public function newMedia($file, $image, $disk, $parentId): Model
    {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $extensions = $file->getClientOriginalExtension();
        $mimeType = $file->getMimeType();
        $name = $file->getClientOriginalName();
        $originalName = $this->generateUniqueName(explode('.', $name)[0], $parentId);
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
     * @return Model|Builder|null
     */
    public function makeFolder(array $inputs = array()): Model|Builder|null
    {
        $name = Arr::get($inputs, 'name', '');
        $parent = Arr::get($inputs, 'parent_id', null);
        if (!empty($name)) {
            $name = $this->generateUniqueName($name, $parent);

            return $this->createOrUpdate(
                ['id' => 0],
                [
                    'name' => $name,
                    'disk' => $this->getDisk(),
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
        // nếu danh sách media không trống, chỉ có 1 phần tử và không phải là thư mục
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

    /**
     * @param array $inputs
     * @return void
     */
    public function renameFile(array $inputs = array()): void
    {
        $id = Arr::get($inputs, 'id', '');
        $media = Media::query()->find($id);
        $parentId = $media->parent_id;
        $originalName = $media->name;
        $inputName = Arr::get($inputs, 'name', '');
        // nếu tên mới khác tên gốc thì mới update dữ liệu
        if ($originalName != $inputName) {
            // Tạo tên mới đảm bảo là duy nhất trong thư mục cha
            $newName = $this->generateUniqueName($inputName, $parentId);
            $disk = $this->getDisk();
            $folder = $this->getFolderName($parentId);
            $folderUpload = '/uploads/';
            // Lấy đường dẫn thư mục cũ và mới
            $directory = $this->getDirectory($folderUpload) . $folder . $originalName . '/';
            $newDirectory = $this->getDirectory($folderUpload) . $folder . $newName . '/';
            // Kiểm tra nếu thư mục cũ tồn tại
            if (Storage::disk($disk)->exists($directory)) {
                $fileInNewDirectories = Storage::disk($disk)->files($directory);
                if (!empty($fileInNewDirectories)) {
                    foreach ($fileInNewDirectories as $file) {
                        // Tạo đường dẫn mới cho từng file
                        $newFile = str_replace($originalName, $newName, $file);

                        // Đổi tên file trong storage
                        Storage::disk($disk)->move($file, $newFile);
                    }
                }
                // Đổi tên folder trong storage
                Storage::disk($disk)->move($directory, $newDirectory);
                // xóa folder cũ
                Storage::disk($disk)->deleteDirectory($directory);
                // Cập nhật CSDL cho các bản ghi con
                $childrens = $media->children->where('is_directory', Media::IS_NOT_DIRECTORY);
                if ($childrens->isNotEmpty()) {
                    foreach ($childrens as $child) {
                        $imageLg = !empty($child->image_lg) ? str_replace($originalName, $newName, $child->image_lg) : '';
                        $imageMd = !empty($child->image_md) ? str_replace($originalName, $newName, $child->image_md) : '';
                        $imageSm = !empty($child->image_sm) ? str_replace($originalName, $newName, $child->image_sm) : '';

                        $child->update([
                            'image_lg' => $imageLg,
                            'image_md' => $imageMd,
                            'image_sm' => $imageSm,
                        ]);
                    }
                }
            }

            if ($media->is_directory == Media::IS_DIRECTORY) {
                $prepareData = [
                    'name' => $newName
                ];
            } else {
                $prepareData = $this->prepareDataImage($media, $originalName, $newName);
                $prepareData['name'] = $newName;
            }

            $media->update($prepareData);
        }
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
        $folder = $this->getFolderName($media->parent_id);
        $path = $this->getDirectory('/uploads/' . $folder . $media->name);
        if (Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->deleteDirectory($path);
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

    private function prepareDataImage($data, $from, $to)
    {
        $imageLg = !empty($data->image_lg) ? str_replace($from, $to, $data->image_lg) : '';
        $imageMd = !empty($data->image_md) ? str_replace($from, $to, $data->image_md) : '';
        $imageSm = !empty($data->image_sm) ? str_replace($from, $to, $data->image_sm) : '';

        return [
            'image_lg' => $imageLg,
            'image_md' => $imageMd,
            'image_sm' => $imageSm,
        ];
    }
}
