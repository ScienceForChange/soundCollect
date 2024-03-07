<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AudioProcessingController extends Controller
{
    use ApiResponses;

    public function process(Request $request)
    {
        // $request->validate([
        //     'audio' => 'required|file|mimes:wav',
        // ]);

        Log::info($request->header('User-Agent'));

        Log::debug(print_r($request, true));

        if(! Storage::disk('sftp')->putFileAs('/home/ubuntu/soundcollect/audio', $request->audio, 'Oficina-X.WAV')) {
            return $this->error('Error al subir el archivo', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        if(! Storage::disk('sftp')->putFileAs('/home/ubuntu/soundcollect/audio/'. strstr($request->user()->email,'@',true), $request->audio, "audio-". str_replace(' ', '-', now()->toDateTimeString()) .".WAV")) {
            return $this->error('Error al subir el archivo.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $response = Http::get('http://18.199.42.2/audio');
        // return $response->json();
        $data = $response->object();

        $LAeqT = collect($data->LAeqT)->map(function ($item) {
            return round($item, 2);
        });

        return $this->success(
            [
                'Leq' => round($data->Leq, 2),
                'LAeqT' => $LAeqT,
                'LAmax' => round($data->Lmax, 2),
                'LAmin' => round($data->Lmin, 2),
                'L90' => round($data->L90, 2),
                'L10' => round($data->L10, 2),
                'sharpness_S' => rand(20, 140),
                'loudness_N' => rand(20, 140),
                'roughtness_R' => rand(20, 140),
                'fluctuation_strength_F' => rand(20, 140),
            ],
            Response::HTTP_OK
        );
    }
}
