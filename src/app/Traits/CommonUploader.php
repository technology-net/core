<?php
namespace IBoot\Core\App\Traits;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait CommonUploader
{
    private array $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    /**
     * Save file to storage
     *
     * @param UploadedFile $file
     * @param $fileName
     * @param $folderPath
     * @return void
     * @throws Exception
     */
    public function saveFile(UploadedFile $file, $fileName, $folderPath): void
    {
        // Store image file
        $disk = $this->getDisk();
        $directory = $this->getDirectory($disk, $folderPath);
        $this->checkMaxSize($file);
        $this->checkFileExtension($file);

        // Create a folder if it doesn't exist
        if (!Storage::disk($disk)->exists($folderPath)) {
            Storage::disk($disk)->makeDirectory($folderPath);
        }

        // Save the file to the storage
        Storage::disk($disk)->putFileAs($folderPath, $file, $fileName);
    }

    /**
     * Get directory
     *
     * @param $disk
     * @param $path
     * @return mixed|string
     */
    private function getDirectory($disk, $path): mixed
    {
        if ($disk === 'local') {
            return 'public' . $path;
        }

        return $path;
    }

    /**
     * Get disk
     *
     * @return mixed
     */
    private function getDisk(): mixed
    {
        return config('filesystems.default');
    }

    /**
     * @param $file
     * @return void
     * @throws Exception
     */
    private function checkMaxSize($file): void
    {
        if ($file->getSize() > 2000000) {
            throw new Exception('File size exceeds maximum limit');
        }
    }

    /**
     * @param $file
     * @return void
     * @throws Exception
     */
    private function checkFileExtension($file): void
    {
        $extension = $file->getClientOriginalExtension();

        if (!in_array($extension, $this->allowedExtensions)) {
            throw new Exception('Invalid file extension');
        }
    }
}
