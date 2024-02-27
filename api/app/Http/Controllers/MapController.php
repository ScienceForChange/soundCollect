<?php

namespace App\Http\Controllers;

use App\Http\Resources\MapObservationResource;
use App\Models\Observation;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        return MapObservationResource::collection(Observation::all());
    }
}
