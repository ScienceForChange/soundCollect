<?php

namespace App\Http\Controllers\Auth;

use App\Enums\OTP\OTP;
use App\Http\Controllers\Controller;
use App\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules\Enum;
class NewPasswordController extends Controller
{
    use ApiResponses;
    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'new_password' => ['required', 'confirmed', Rules\Password::defaults()],
            'otp' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();
        // Take the active OTP of current user
        $activeOtp = $user->activeOtp(OTP::NEW_PASSWORD);

        if( !$activeOtp || $activeOtp->otp !== $request->otp ){
            return $this->fail(
                [
                    'message' => 'OTP is invalid'
                ],
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $newPassword = $request->new_password;

        $user->password = Hash::make($newPassword);

        $user->save();

        $activeOtp->update([
            'is_used' => true
        ]);

        event(new PasswordReset($user, $newPassword));

        return $this->success(
            [
                'message' => 'Password reset successfully'
            ],
            Response::HTTP_CREATED);
    }
}
