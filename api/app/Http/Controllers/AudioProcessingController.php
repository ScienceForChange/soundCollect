<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponses;
use AWS\CRT\HTTP\Response;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

class AudioProcessingController extends Controller
{
    use ApiResponses;

    public function process(Request $request)
    {
        $request->validate([
            'audio' => 'required|file|mimes:wav',
        ]);

        return $this->success(
            [
                'Leq' => rand(20, 140),
                'LAeqT' => [rand(20, 140), rand(20, 140), rand(20, 140), rand(20, 140), rand(20, 140)],
                'LAmax' => rand(20, 140),
                'LAmin' => rand(20, 140),
                'L90' => rand(20, 140),
                'L10' => rand(20, 140),
                'sharpness_S' => rand(20, 140),
                'loudness_N' => rand(20, 140),
                'roughtness_R' => rand(20, 140),
                'fluctuation_strength_F' => rand(20, 140),
            ],
            HttpResponse::HTTP_OK
        );
    }
}
