<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Send a standardized JSON success response.
     *
     * @param  mixed  $data
     * @param  string|null  $message
     * @param  int  $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data = null, $message = null, $status = 200)
    {
        return response()->json([
            'status'  => 'success',
            'message' => $message,
            'data'    => $data
        ], $status);
    }

    /**
     * Send a standardized JSON error response.
     *
     * @param  string  $message
     * @param  int  $status
     * @param  mixed|null  $errors
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message, $status = 400, $errors = null)
    {
        return response()->json([
            'status'  => 'error',
            'message' => $message,
            'errors'  => $errors
        ], $status);
    }
}
