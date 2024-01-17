<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VerificationCode;
use Illuminate\Support\Str;
use App\Traits\ApiResponses;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules\Enum;

class AuthOtpController extends Controller
{
    use ApiResponses;

    // Generate OTP
    public function generate(Request $request)
    {
        # Validate Data
        $request->validate([
            'email' => ['required','exists:users,email', 'email'],
            'type' => ['required',new Enum(\App\Enums\OTP\OTP::class)],
        ]);

        $user = User::where('email', $request->email)->first();
        $type = $request->type;

        // if ($request->user()->email !== $user->email) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'You are not authorized to perform this action'
        //     ], 403);
        // }

        # Generate An OTP
        $verificationCode = $this->generateOtp($user, $type);

        # Send OTP to User
        try{
            $user->sendEmailOtpNotification($verificationCode);
        }
        catch(\Exception $e){
            return $this->error([
                'message' => 'Unable to Send OTP'
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        # Prompt OTP
        $message = "OTP Sent Successfully ($verificationCode->otp)";

        # Return With OTP
        return $this->success([
            'message' => $message,
        ],
        Response::HTTP_CREATED);
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
