<?php

namespace IBoot\Core\app\MediaCollections;

use IBoot\Core\app\Contracts\HasMedia;
use IBoot\Core\app\Contracts\PathGenerator as PathGeneratorContract;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

class PathGenerator implements PathGeneratorContract
{
    public function getName(HasMedia $model, File|UploadedFile|RemoteFile $file): string
    {
        return $file->hashName();
    }

    public function getDirectory(HasMedia $model, File|UploadedFile|RemoteFile $file): string
    {
        return join('/', [date('Y'), date('m')]);
    }
}
