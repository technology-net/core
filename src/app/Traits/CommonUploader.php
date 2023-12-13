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
            $directory = $this->getDirectory($path) . $originalName . '/';
            $path = $path . $originalName . '/';
            $this->checkMaxSize($fileName);
            // Create a folder if it doesn't exist
            if (!Storage::disk($disk)->exists($directory)) {
                Storage::disk($disk)->makeDirectory($directory);
            }
            $contents = file_get_contents($fileName->getRealPath());
            if (in_array(strtolower($extension), $this->allowedExtensions)) {
                $imageName = $this->generateVariantsImage($contents, $directory, $originalName, $path,);
                $imageMd = $this->generateVariantsImage($contents, $directory, $originalName, $path, ['width' => 800, 'height' => 450]);
                $imageSm = $this->generateVariantsImage($contents, $directory, $originalName, $path, ['width' => 300, 'height' => 300], true);
            } else {
                $imageName = [
                    'file_path' => $originalName . '-' . time() . '.' . $extension,
                    'file_size' => $fileName->getSize(),
                ];
                // Save the image to the specified directory on the selected disk
                Storage::disk($disk)->put($directory . $imageName['file_path'], $contents);
            }

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
     * @param $path
     * @param array $sizes
     * @param bool $isThumbnail
     * @return array{file_path: string, file_size: false|int}
     */
    public function generateVariantsImage($contents, $directory, $originalName, $path, array $sizes = array(), bool $isThumbnail = false): array
    {
        $disk = $this->getDisk();
        // Load the original image
        $originalImage = imagecreatefromstring($contents);

        // Get the original image dimensions
        $originalWidth = imagesx($originalImage);
        $originalHeight = imagesy($originalImage);

        if (!empty($sizes)) {
            // Define the dimensions for your thumbnail
            $width = $sizes['width'];
            $height = $sizes['height'];

            // Calculate the aspect ratios of the original image and the desired dimensions
            $originalRatio = $originalWidth / $originalHeight;
            $desiredRatio = $width / $height;

            if ($isThumbnail && ($originalWidth / $originalHeight != 1)) {
                // Determine whether to crop from the top or sides
                if ($originalWidth > $originalHeight) {
                    $cropWidth = $originalHeight;
                    $cropHeight = $originalHeight;
                    $cropX = ($originalWidth - $originalHeight) / 2;
                    $cropY = 0;
                } else {
                    $cropWidth = $originalWidth;
                    $cropHeight = $originalWidth;
                    $cropX = 0;
                    $cropY = ($originalHeight - $originalWidth) / 2;
                }

                $newWidth = $width;
                $newHeight = $height;
                // Create an empty square thumbnail image
                $variantsImage = imagecreatetruecolor($newWidth, $newHeight);
                $transparentColor = imagecolorallocatealpha($variantsImage, 255, 255, 255, 127);
                imagefill($variantsImage, 0, 0, $transparentColor);
                imagecopyresampled($variantsImage, $originalImage, 0, 0, $cropX, $cropY, $newWidth, $newHeight, $cropWidth, $cropHeight);
            } else {
                if ($originalRatio > $desiredRatio) {
                    $newWidth = $width;
                    $newHeight = round($width / $originalRatio);
                } else {
                    $newWidth = round($height * $originalRatio);
                    $newHeight = $height;
                }

                $variantsImage = imagecreatetruecolor($newWidth, $newHeight);
                $transparentColor = imagecolorallocatealpha($variantsImage, 255, 255, 255, 127);
                imagefill($variantsImage, 0, 0, $transparentColor);
                imagecopyresampled($variantsImage, $originalImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
            }
        } else {
            $newWidth = $originalWidth;
            $newHeight = $originalHeight;
            $variantsImage = imagecreatetruecolor($newWidth, $newHeight);
            $transparentColor = imagecolorallocatealpha($variantsImage, 255, 255, 255, 127);
            imagefill($variantsImage, 0, 0, $transparentColor);
            imagecopyresampled($variantsImage, $originalImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
        }

        // Create an empty thumbnail image
        $variantsImageName = $originalName . '-' . time() . '-' . $newWidth . 'x' . $newHeight . '.webp';
        imagejpeg($variantsImage, Storage::disk($disk)->path($directory . $variantsImageName), 100);

        $filePath = Storage::disk($disk)->path($directory . $variantsImageName);
        $fileSize = filesize($filePath);

        // Destroy the images to free up memory
        imagedestroy($originalImage);
        imagedestroy($variantsImage);

        return [
            'file_path' => $path . $variantsImageName,
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
}
