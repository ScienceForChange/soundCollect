<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegisteredUserRequest;
use App\Models\{User, ProfileCitizen};
use App\Traits\ApiResponses;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class RegisteredUserController extends Controller
{
    use ApiResponses;
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(StoreRegisteredUserRequest $request): JsonResponse
    {

        // restrict users under 14 years to register
        $birthYear = $request->birth_year;
        $currentYear = date('Y');
        $age = $currentYear - $birthYear;

        if ($age < 14) {
            return $this->error('You must be at least 14 years old to register.', Response::HTTP_BAD_REQUEST);
        }
        
        
        $citizen = ProfileCitizen::create([
            'name' => $request->name,
            'gender' => $request->gender,
            'birth_year' => $request->birth_year,
        ]);

        $user = $citizen->user()->create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar_id' => 1,
        ]);

        return $this->success(
            [
                'user'  => new UserResource($user),
                'token' => $user->createToken(request('email'))->plainTextToken
            ],
            Response::HTTP_CREATED
        );
    }
}
