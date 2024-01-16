<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use App\Http\Requests\EmailVerificationRequest;
use Illuminate\Http\JSONResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): JSONResponse
    {
        // Take the active OTP of current user
        $activeOtp = $request->user()->activeOtp();

        if( $activeOtp && $activeOtp->otp !== $request->otp ){
            return response()->json(['message' => 'OTP is invalid']);
        }

        if( $request->user()->hasVerifiedEmail() ){
            return response()->json(['message' => 'Already verified']);
        }

        $request->user()->markEmailAsVerified();

        return response()->json(['message' => 'Successfully verified']);
    }
}
