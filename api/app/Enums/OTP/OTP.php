<?php

namespace App\Enums\OTP;

enum OTP: string {
	case VERIFY_EMAIL = 'verify-email';
    case NEW_PASSWORD = 'new-password';
}
