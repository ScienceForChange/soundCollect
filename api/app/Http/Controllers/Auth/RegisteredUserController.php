<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3','max:100'],
            'birth_year' => ['required', 'string'], // Se puede poner una lógica de mínimo de edad, máximo, etc
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class.',email'],
            'gender' => ['required', new Enum(\App\Enums\Citizen\Gender::class)],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'device_name' => ['required', 'string', 'max:255'],
        ]);

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

        event(new Registered($user));

        // Auth::login($user);

        return $this->success(
            $user
                ->createToken(request('device_name'))
                ->plainTextToken,
            Response::HTTP_CREATED
        );
    }
}
