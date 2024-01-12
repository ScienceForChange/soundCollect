<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\OtpGenerated;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class SendOtpNotification
{
    /**
     * Handle the event.
     */
    public function handle(OtpGenerated $event): void
    {
        $event->user->sendEmailOtpNotification($event->otp);
    }
}
