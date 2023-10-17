<?php

namespace IBoot\Core\app\Exceptions;

use Illuminate\Http\JsonResponse;

class BadRequestException extends BaseException
{
    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return responseBadRequest(null, $this->message);
    }
}
