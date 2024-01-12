<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class EnsureOtpIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(! $request->otp)
        {
            return response()->json(['message' => 'OTP is required.'], 400);
        }

        if(! $request->user()->hasValidOtp()?->where('otp', Str::upper($request->otp))->exists())
        {
            return response()->json(['message' => 'OTP is invalid.'], 400);
        }

        return $next($request);
    }
}
