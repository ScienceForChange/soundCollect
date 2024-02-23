<?php

namespace App\Http\Controllers\Auth;

use App\Enums\OTP\OTP;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use App\Http\Requests\EmailVerificationRequest;
use App\Traits\ApiResponses;
use Illuminate\Http\JSONResponse;
use Illuminate\Http\Response;
use App\Models\User;

class VerifyEmailController extends Controller
{
    use ApiResponses;
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): JSONResponse
    {
        $user = User::where('email', $request->email)->first();
        // Take the active OTP of current user
        $activeOtp = $user->activeOtp(OTP::VERIFY_EMAIL);

        if( !$activeOtp || $activeOtp->otp !== $request->otp ){
            return $this->fail([
                'message' => 'Invalid OTP'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if( $user->hasVerifiedEmail() ){
            return $this->fail([
                'message' => 'Already verified'
            ], Response::HTTP_CONFLICT);
        }

        $user->markEmailAsVerified();

        $activeOtp->update([
            'is_used' => true
        ]);

        return $this->success([
            'message' => 'Email verified'
        ],
        Response::HTTP_OK);
    }
}
