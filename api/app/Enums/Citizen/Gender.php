<?php

namespace App\Enums\Citizen;

enum Gender: string {
	case MALE = 'hombre';
    case FEMALE = 'mujer';
    case NON_BINARY = 'no binarie';
    case OTHERS = 'otros';
    case PREFER_NOT_TO_SAY = 'prefiere no decir';
}
