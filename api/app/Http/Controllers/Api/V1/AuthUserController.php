<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Traits\ApiResponses;
use Illuminate\Http\Response;

class AuthUserController extends Controller
{
    use ApiResponses;
    /**
     * Display the authenticated user.
     */
    public function show(Request $request)
    {
        return $this->success(
            new UserResource($request->user()),
            Response::HTTP_CREATED
        );
    }

    public function verified(Request $request)
    {
        return 'user verified';
    }
}
