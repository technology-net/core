<?php
namespace IBoot\Core\App\Traits;

use Exception;
use IBoot\Core\App\Models\SystemSetting;
use Illuminate\Support\Facades\Storage;

trait CommonUploader
{
    private array $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    /**
     * @param $fileName
     * @param $path
     * @return array|string
     * @throws Exception
     */
    public function saveFile($fileName, $path): array|string
    {
        if (!empty($fileName)) {
            $originalName = $fileName->getClientOriginalName();
            list($originalName, $extension) = explode('.', $originalName);
            $disk = $this->getDisk();
            $directory = $this->getDirectory($path);
            if (in_array($extension, $this->allowedExtensions)) {
                $directory = $directory . $originalName . '/';
                $path = $path . $originalName . '/';
            }
            $this->checkMaxSize($fileName);
            // Create a folder if it doesn't exist
            if (!Storage::disk($disk)->exists($directory)) {
                Storage::disk($disk)->makeDirectory($directory);
            }
            $contents = file_get_contents($fileName->getRealPath());
            if (in_array($extension, $this->allowedExtensions)) {
                $imageName = $this->convertImageToWebp($contents, $directory, $originalName, $path,);
                $imageMd = $this->generateVariantsImage($contents, $directory, $originalName, $path, ['width' => 800, 'height' => 450]);
                $imageSm = $this->generateVariantsImage($contents, $directory, $originalName, $path, ['width' => 200, 'height' => 200]);
            } else {
                $imageName = [
                    'file_name' => $path . $originalName . '-' . time() . '.' . $extension,
                    'file_size' => $fileName->getSize(),
                ];
            }
            // Save the image to the specified directory on the selected disk
            Storage::disk($disk)->put($directory . $imageName['file_name'], $contents);

            return [
                'image_lg' => $imageName,
                'image_md' => !empty($imageMd) ? $imageMd : '',
                'image_sm' => !empty($imageSm) ? $imageSm : '',
            ];
        }

        return '';
    }

    /**
     * @param $contents
     * @param $directory
     * @param $originalName
     * @param array $sizes
     * @return array
     */
    public function generateVariantsImage($contents, $directory, $originalName, $path, array $sizes = array()): array
    {
        $disk = $this->getDisk();
        // Load the original image
        $originalImage = imagecreatefromstring($contents);

        // Get the original image dimensions
        $originalWidth = imagesx($originalImage);
        $originalHeight = imagesy($originalImage);

        // Define the dimensions for your thumbnail
        $width = $sizes['width'];
        $height = $sizes['height'];

        // Calculate the aspect ratios of the original image and the desired dimensions
        $originalRatio = $originalWidth / $originalHeight;
        $desiredRatio = $width / $height;

        if ($originalRatio > $desiredRatio) {
            $newWidth = $width;
            $newHeight = round($width / $originalRatio);
        } else {
            $newWidth = round($height * $originalRatio);
            $newHeight = $height;
        }

        // Create an empty thumbnail image
        $variantsImage = imagecreatetruecolor($newWidth, $newHeight);
        $variantsImageName = $originalName . '-' . time() . '-' . $newWidth . 'x' . $newHeight . '.webp';

        // Resize the original image to fit the thumbnail dimensions
        imagecopyresampled($variantsImage, $originalImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
        imagejpeg($variantsImage, Storage::disk($disk)->path($directory . $variantsImageName));

        $filePath = Storage::disk($disk)->path($directory . $variantsImageName);
        $fileSize = filesize($filePath);

        // Destroy the images to free up memory
        imagedestroy($originalImage);
        imagedestroy($variantsImage);

        return [
            'file_name' => $path . $variantsImageName,
            'file_size' => $fileSize,
        ];
    }

    /**
     * @param $path
     * @return mixed
     */
    private function getDirectory($path): mixed
    {
        $disk = $this->getDisk();
        if (str_contains($disk, 'local')) {
            return 'public' . $path;
        }

        return $path;
    }

    /**
     * @return mixed
     */
    private function getDisk(): mixed
    {
        $disk = SystemSetting::query()
            ->where('key', 'filesystem_disk')
            ->first();
        if (!empty($disk)) {
            $setting = SystemSetting::query()
                ->where('key', $disk->value)
                ->first();

            config([
                'filesystems.default' => $disk->value,
            ]);
            config([
                'filesystems.disks.' . $setting->key  => json_decode($setting->value, true),
            ]);
        }

        return config('filesystems.default');
    }

    /**
     * @param $file
     * @return void
     * @throws Exception
     */
    private function checkMaxSize($file): void
    {
        $size = 5000000; //Byte
        $setting = SystemSetting::query()
            ->where('key', 'max_size_image')
            ->first();
        if ($setting) {
            $size = $setting->value;
        }
        $megabyte = $size / 1000000;
        if ($file->getSize() > $size) {
            throw new Exception(trans('packages/core::messages.max_size', [ 'num' => $megabyte]));
        }
    }

    /**
     * @param $imageString
     * @param $directory
     * @param $originalName
     * @return array
     */
    private function convertImageToWebp ($imageString, $directory, $originalName, $path): array
    {
        $disk = $this->getDisk();
        // Create a new image from the image stream in the string
        $originalImage = imagecreatefromstring($imageString);
        // Converts a palette based image to true color
        imagepalettetotruecolor($originalImage);
        $size = $this->getSizeImage($imageString);
        $imageName = $originalName . '-' . time() . '-' . $size . '.webp';
        // Convert file to webp
        imagewebp($originalImage, Storage::path($directory . $imageName));
        $filePath = Storage::disk($disk)->path($directory . $imageName);
        $fileSize = filesize($filePath);
        // Frees image object memory
        imagedestroy($originalImage);

        return [
            'file_name' => $path . $imageName,
            'file_size' => $fileSize,
        ];
    }

    /**
     * @param $strDecodeBase64
     * @return string
     */
    private function getSizeImage($strDecodeBase64): string
    {
        $image = imagecreatefromstring($strDecodeBase64);
        $width = imagesx($image);
        $height = imagesy($image);

        return $width . 'x' . $height;
    }
}
