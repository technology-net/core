<?php

namespace IBoot\Core\app\Exceptions;

use Illuminate\Http\JsonResponse;

class ServerErrorException extends BaseException
{
    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return responseServerError(null, $this->message);
    }
}
