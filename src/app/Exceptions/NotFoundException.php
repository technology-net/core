<?php

namespace IBoot\Core\App\Exceptions;

use Illuminate\Http\JsonResponse;

class NotFoundException extends BaseException
{
    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return responseNotFound(null, $this->message);
    }
}
