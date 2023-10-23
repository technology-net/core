<?php

namespace IBoot\Core\app\MediaCollections;

class MediaCollection
{
    protected string $name;
    protected ?string $diskName = null;
    protected ?int $size = null;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function onlyKeepLatest(int $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function singleFile(): static
    {
        $this->onlyKeepLatest(1);

        return $this;
    }

    public function useDisk(string $name): static
    {
        $this->diskName = $name;

        return $this;
    }

    public function getDiskName(): string
    {
        return $this->diskName ?? 'public';
    }
}
