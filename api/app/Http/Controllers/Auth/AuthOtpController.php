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
            'email' => 'required|exists:users,email'
        ]);

        # Generate An OTP
        $verificationCode = $this->generateOtp($request->email);

        $message = "Your OTP is - ".$verificationCode->otp;
        # Return With OTP

        return response()->json([
            'status' => 'success',
            'message' => $message
        ]);
    }

    public function generateOtp($email)
    {
        $user = User::where('email', $email)->first();

        # User Does not Have Any Existing OTP
        $verificationCode = VerificationCode::where('user_id', $user->id)->latest()->first();

        $now = Carbon::now();

        if($verificationCode && $now->isBefore($verificationCode->expire_at)){
            $user->sendEmailOtpNotification($verificationCode);
            return $verificationCode;
        }

        // Create a New OTP
        $verificationCode = VerificationCode::create([
            'user_id' => $user->id,
            'otp' => Str::upper(Str::random(4)),
            'is_used' => false,
            'expire_at' => Carbon::now()->addMinutes(10)
        ]);



        return $verificationCode;
    }
}
