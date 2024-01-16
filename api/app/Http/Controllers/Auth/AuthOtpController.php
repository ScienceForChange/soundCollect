<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VerificationCode;
use Illuminate\Support\Str;
use App\Events\OtpGenerated;

class AuthOtpController extends Controller
{
    // Generate OTP
    public function generate(Request $request)
    {
        # Validate Data
        $request->validate([
            'email' => 'required|exists:users,email',
            'type' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        $type = $request->type;

        if ($request->user()->email !== $user->email) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to perform this action'
            ], 403);
        }

        # Generate An OTP
        $verificationCode = $this->generateOtp($user, $type);

        # Send OTP to User
        $user->sendEmailOtpNotification($verificationCode);

        # Prompt OTP
        $message = "Your OTP is - ".$verificationCode->otp;

        # Return With OTP
        return response()->json([
            'status' => 'success',
            'message' => $message
        ]);
    }

    public function generateOtp(User $user, string $type)
    {
        # User Does not Have Any Existing OTP
        $verificationCode = VerificationCode::where('user_id', $user->id)
        ->where('expire_at', '>', Carbon::now())
        ->where('is_used', false)
        ->first();

        if($verificationCode){
            return $verificationCode;
        }

        // Create a New OTP
        $verificationCode = VerificationCode::create([
            'user_id' => $user->id,
            'otp' => Str::upper(Str::random(4)),
            'type' => $type,
            'is_used' => false,
            'expire_at' => Carbon::now()->addMinutes(10)
        ]);

        return $verificationCode;
    }
}
