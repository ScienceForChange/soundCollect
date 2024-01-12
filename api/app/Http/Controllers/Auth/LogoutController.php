<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        return request()
            ->user()
            ->currentAccessToken()
            ->delete();
    }
}
