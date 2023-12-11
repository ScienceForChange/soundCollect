<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     * EmailVerificationRequest
     */
    public function __invoke(Request $request): RedirectResponse
    {
        if(!Auth::check()) {
            $user = \App\Models\User::find($request->route('id'));

            if (! hash_equals(sha1($user->getEmailForVerification()), (string) $request->route('hash'))) {
                throw new AuthorizationException;
            }

            if ($user->markEmailAsVerified())
                event(new Verified($user));

            return redirect()->intended(
                config('app.frontend_url').RouteServiceProvider::HOME
            );
        }

        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(
                config('app.frontend_url').RouteServiceProvider::HOME.'?verified=1'
            );
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(
            config('app.frontend_url').RouteServiceProvider::HOME.'?verified=1'
        );
    }
}
