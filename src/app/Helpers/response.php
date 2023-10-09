<?php

use IBoot\Core\app\Exceptions\ForbiddenException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

// 200
if (!function_exists('responseSuccess')) {
    function responseSuccess($data = [], $message = null): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'success' => true,
            'message' => $message ?: trans('messages.http.success'),
        ], Response::HTTP_OK);
    }
}

// 400
if (!function_exists('responseBadRequest')) {
    function responseBadRequest($data = [], $message = null): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'success' => false,
            'message' => $message ?: trans('messages.http.bad_request'),
        ], Response::HTTP_BAD_REQUEST);
    }
}

// 401
if (!function_exists('responseUnauthorized')) {
    function responseUnauthorized($data = [], $message = null): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'success' => false,
            'message' => $message ?: trans('messages.http.unauthorized'),
        ], Response::HTTP_UNAUTHORIZED);
    }
}

// 403
if (!function_exists('responseForbidden')) {
    function responseForbidden($data = [], $message = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'data' => $data,
            'message' => $message ?: trans('messages.http.forbidden'),
        ], Response::HTTP_FORBIDDEN);
    }
}

// 404
if (!function_exists('responseNotFound')) {
    function responseNotFound($data = [], $message = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'data' => $data,
            'message' => $message ?: trans('messages.http.not_found'),
        ], Response::HTTP_NOT_FOUND);
    }
}

// 422
if (!function_exists('responseUnprocessableEntity')) {
    function responseUnprocessableEntity($data = [], $message = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'data' => $data,
            'message' => $message ?: trans('messages.http.not_found'),
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}

// 500
if (!function_exists('responseServerError')) {
    function responseServerError($data = [], $message = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'data' => $data,
            'message' => $message ?: trans('messages.http.server_error'),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
