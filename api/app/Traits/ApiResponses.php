<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponses
{
    protected function success($data = [], $code = Response::HTTP_OK, $headers = [])
    {
        return new JsonResponse([
            'status' => 'success',
            'data' => $data,
        ], $code,
        $headers);
    }

    protected function fail($data, $code = 422)
    {
        return new JsonResponse([
            'status' => 'fail',
            'data' => $data,
        ], $code);
    }

    protected function error($message = 'something went wrong...', $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        return new JsonResponse([
            'status' => 'error',
            'message' => $message
        ], $code);
    }
}
