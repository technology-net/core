<?php

namespace IBoot\Core\app\MediaCollections;

use IBoot\Core\app\Contracts\HasMedia;
use IBoot\Core\app\Models\Media;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

class FileAdder
{
    use Macroable;

    protected ?HasMedia $model;
    protected File|UploadedFile|RemoteFile $file;
    protected bool $preserveOriginal = false;
    protected string $mediaName;
    protected string $mediaDirectory;

    public function __construct(HasMedia $model, File|UploadedFile|RemoteFile $file)
    {
        $this->model = $model;
        $this->file = $file;
    }

    public function preservingOriginal(bool $preserveOriginal = true): self
    {
        $this->preserveOriginal = $preserveOriginal;

        return $this;
    }

    public function usingName(string $name): self
    {
        $this->mediaName = $name;

        return $this;
    }

    public function usingDirectory(string $directory): static
    {
        $this->mediaDirectory = $directory;

        return $this;
    }

    public function toMediaCollection(string $name = 'default'): void
    {
        $collection = $this->model->getMediaCollection($name);

        if (null === $collection) {
            $collection = new MediaCollection($name);
        }

        $mediaClass = Media::class;
        $media = new $mediaClass();
        $media->disk = $collection->getDiskName();
        $media->collection_name = $collection->getName();
        $media->mime_type = $this->file->getMimeType();
        $media->size = $this->file->getSize();
        $media->name = $this->determineMediaName($this->model, $this->file);
        $media->directory = $this->determineMediaDirectory($this->model, $this->file);
        $this->model->media()->save($media);

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk($media->disk);
        if ($this->file instanceof RemoteFile) {
            $disk->put($media->path, $this->file->readStream());
        } else {
            $disk->putFileAs($media->directory, $this->file, $media->name);
        }

        if (!$this->preserveOriginal) $this->deleteFile();

        // We should perform a new query here,

        $collection = $this->model->media()->where('collection_name', $collection->getName())->get();
dd($collection->getSize());
        $size = $collection->getSize();
        if (null !== $size = $this->file->getSize() and $size < $count = $collection->count()) {
            $collection->take($count - $size)->each->delete();
        }
    }

    protected function deleteFile(): void
    {
        if ($this->file instanceof RemoteFile) {
            $this->file->delete();
        } else {
            unlink($this->file->path());
        }
    }

    protected function getPathGenerator(): PathGenerator
    {
        return resolve(PathGenerator::class);
    }

    protected function determineMediaName(HasMedia $model, $file): string
    {
        return $this->mediaName ?? $this->getPathGenerator()->getName($model, $file);
    }

    protected function determineMediaDirectory(HasMedia $model, $file): string
    {
        return $this->mediaDirectory ?? $this->getPathGenerator()->getDirectory($model, $file);
    }
}
