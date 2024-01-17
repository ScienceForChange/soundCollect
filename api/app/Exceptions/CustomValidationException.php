<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class CustomValidationException extends ValidationException
{
    public function render($request): JsonResponse
    {
        return new JsonResponse([
            // This is the array that you will return in case of an error.
            // You can put whatever you want inside.
            'message' => 'There were some errors',
            'errorCode' => 100,
            // 'additionalThings' => 'Some additional things',
            'errors' => $this->validator->errors()->getMessages(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
