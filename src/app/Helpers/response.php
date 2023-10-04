<?php

use Illuminate\Http\JsonResponse;

if (!function_exists('responseJson')) {
    function responseJson($data = [], $statusResponse = false, $message = null): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'success' => $statusResponse,
            'message' => $message
        ]);
    }
}
