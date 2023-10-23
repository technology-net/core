<?php

namespace IBoot\Core\app\Contracts;

use IBoot\Core\app\MediaCollections\RemoteFile;
use IBoot\Core\app\Models\Media;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

interface PathGenerator
{
    public function getName(HasMedia $model, File|UploadedFile|RemoteFile $file): string;
    public function getDirectory(HasMedia $model, File|UploadedFile|RemoteFile $file): string;
}
