<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponses;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class PolylineObservationController extends Controller
{
    public function index()
    {
        try {
            
            return new JsonResponse([
                'status' => 'success',
                'data' => 'test polyline observation index',
            ], 200);
            

        } catch (\Throwable $th) {
           return 'General error on polyline observations controller is: '. $th;
        }
    }
}
