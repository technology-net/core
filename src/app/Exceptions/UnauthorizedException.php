<?php

namespace IBoot\Core\App\Exceptions;

use Illuminate\Http\JsonResponse;

class UnauthorizedException extends BaseException
{
    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return responseUnauthorized(null, $this->message);
    }
}
