<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use App\Rules\TeenAgeCare;
use App\Traits\ApiResponses;
use App\Http\Resources\UserResource;
use Illuminate\Http\Response;

class EditUserController
{
    use ApiResponses;

    public function __invoke(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'birth_year'    => ['required', 'numeric','between:1900,2100', new TeenAgeCare()],
            'gender'        => ['required', new Enum(\App\Enums\Citizen\Gender::class)],
        ]);

        $user->profile()->update([
            'birth_year'    => $request->birth_year,
            'gender'    => $request->gender
        ]);

        return $this->success(
            [
                'user'  => new UserResource(\App\Models\User::find($user->id)),
            ],
            Response::HTTP_OK
        );

    }
}
