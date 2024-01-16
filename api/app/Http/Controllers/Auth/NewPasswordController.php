<?php

namespace App\Http\Controllers\Auth;

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

class NewPasswordController extends Controller
{
    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required'],
        ]);

        $user = User::where('email', $request->email)->firstOrFail();
        // Take the active OTP of current user
        $activeOtp = $user->activeOtp();

        if( !$activeOtp || $activeOtp->otp !== $request->otp ){
            return response()->json(['message' => 'OTP is invalid']);
        }


        $newPassword = Str::random(8);

        $user->password = Hash::make($newPassword);

        $user->save();

        event(new PasswordReset($user, $newPassword));

        return response()->json(['message' => 'Password reset successfully']);
    }
}
