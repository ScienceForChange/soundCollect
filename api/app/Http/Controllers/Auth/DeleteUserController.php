<?php

namespace App\Http\Controllers\Auth;

use App\Traits\ApiResponses;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class DeleteUserController
{
    use ApiResponses;
    public function __invoke()
    {
        $user = auth()->user();

        $user->otp()->delete();

        $user->delete();

        return $this->success(
            [
                'message' => 'User deleted successfully',
            ],
            Response::HTTP_OK
        );
    }
}
