<?php
namespace IBoot\Core\app\Traits;

use Exception;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait CommonUploader
{
    public static function saveFile(UploadedFile $uploadedFile, $fileName, $folderPath): void
    {
        // Store image file
        $disk = self::getImageDisk();
        if ($disk == 'local') {
            $folderPath = 'public'.$folderPath;
        }

        // Create a folder if not exist
        if (!Storage::disk($disk)->exists($folderPath)) {
            Storage::disk($disk)->makeDirectory($folderPath);
        }

        // Save the file to the storage
       Storage::disk($disk)->putFileAs($folderPath, $uploadedFile, $fileName);
    }

    /**
     * @param $path
     * @return string
     */
    private static function getImagePath($path): string
    {
        return config('file_uploads.folder') . DIRECTORY_SEPARATOR . $path;
    }

    /**
     * [getImageDisk description]
     * @param null $default
     * @return Repository|Application|\Illuminate\Foundation\Application|mixed [type] [description]
     */
    public static function getImageDisk($default = null): mixed
    {
        return $default ?: config('file_uploads.disk');
    }

    /**
     * Delete file by path and prefix
     * @param  [type] $filePath path of file
     * @return bool [type] [description]
     */
    public static function deleteImage($filePath): bool
    {
        $disk = self::getImageDisk();
        try {
            if (!empty($filePath)) {
                // delete file
                Storage::disk($disk)->delete($filePath);
            }

            return true;
        } catch (Exception $e) {
            Log::error($e);

            return false;
        }
    }
}
