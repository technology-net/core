<?php

namespace IBoot\Core\app\Contracts;

use IBoot\Core\app\MediaCollections\FileAdder;
use IBoot\Core\app\MediaCollections\MediaCollection;
use IBoot\Core\app\MediaCollections\RemoteFile;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

interface HasMedia
{
    public function media(): Relation;

    public function addMedia(File|UploadedFile|RemoteFile $file): FileAdder;

    public function addMediaCollection(string $name): MediaCollection;

    public function getMediaCollection(string $name): ?MediaCollection;
}
