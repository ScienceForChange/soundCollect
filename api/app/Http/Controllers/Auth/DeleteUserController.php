<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;

class DeleteUserController
{
    public function __invoke()
    {
        $user = auth()->user();

        $user->delete();
    }
}
