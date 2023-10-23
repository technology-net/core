<?php

namespace IBoot\Core\app\Exceptions\Media;

class RequestDoesNotHaveFile extends FileCannotBeAdded
{
    public static function create(string $key): self
    {
        return new static("The current request does not have a file in a key named `{$key}`");
    }
}
