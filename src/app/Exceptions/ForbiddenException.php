<?php

namespace IBoot\Core\app\Exceptions;

use Illuminate\Http\JsonResponse;

class ForbiddenException extends BaseException
{
    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return responseForbidden(null, $this->message);
    }
}
