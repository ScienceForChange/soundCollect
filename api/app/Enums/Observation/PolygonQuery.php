<?php

namespace App\Enums\Observation;

enum PolygonQuery: string {
	case INSIDE = 'inside';
    case OUTSIDE = 'outside';
    case BOUNDARY = 'boundary';
    case VERTEX = 'vertex';
}
