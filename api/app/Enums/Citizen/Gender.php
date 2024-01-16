<?php

namespace App\Enums\Citizen;

enum Gender: string {
	case MALE = 'male';
    case FEMALE = 'female';
    case NON_BINARY = 'non-binary';
    case OTHERS = 'others';
    case PREFER_NOT_TO_SAY = 'prefer-not-to-say';
}
