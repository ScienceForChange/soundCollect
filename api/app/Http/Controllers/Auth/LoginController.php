<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use ApiResponses;

    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => ['required','email'],
            'password' => 'required',
        ]);

        $user = User::query()
          ->where('email', $request->email)
          ->first();

        if (
             !$user ||
             !Hash::check(
                     $request->password,
                     $user->password
            )
        ) {
              throw ValidationException::withMessages([
                   'message' => [
                    'The provided credentials are incorrect.'
                   ],
            ]);
        }

        return $this->success(
            [
                'user'  => new UserResource($user),
                'token' => $user->createToken(request('email'))->plainTextToken
            ],
            Response::HTTP_OK
        );
    }

}
