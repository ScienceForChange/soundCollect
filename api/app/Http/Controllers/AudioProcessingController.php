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
                'Leq' => rand(40, 100),
                'LAeqT' => [rand(40, 100), rand(40, 100), rand(40, 100), rand(40, 100), rand(40, 100)],
                'LAmax' => rand(40, 100),
                'LAmin' => rand(40, 100),
                'L90' => rand(40, 100),
                'L10' => rand(40, 100),
                'sharpness_S' => rand(40, 100),
                'loudness_N' => rand(40, 100),
                'roughtness_R' => rand(40, 100),
                'fluctuation_strength_F' => rand(40, 100),
            ],
            HttpResponse::HTTP_OK
        );
    }
}
