<?php

namespace IBoot\Core\App\Exceptions;

use Exception;

/**
 * @property mixed $data
 */
class BaseException extends Exception
{
    public function __construct($data, $message)
    {
        $this->data = $data;
        parent::__construct($message);
    }
}
