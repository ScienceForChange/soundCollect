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

        // $message = $request->header('User-Agent');
        // Log::emergency($message);
        // Log::alert($message);
        // Log::critical($message);
        // Log::error($message);

        if(! Storage::disk('sftp_to_new_flask_2cpu')->putFileAs('/home/ubuntu/SoundCollect_flask/audio', $request->audio, 'Oficina-X.WAV')) {
            return $this->error('Error when saving audio.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        // if(! Storage::disk('sftp')->putFileAs('/home/ubuntu/SoundCollect_flask/audio/'. strstr($request->user()->email,'@',true), $request->audio, "audio-". str_replace(' ', '-', now()->toDateTimeString()) .".WAV")) {
        //     return $this->error('Error when trying to create user named folder to save audio.', Response::HTTP_INTERNAL_SERVER_ERROR);
        // }

        // $response = Http::get('http://18.199.42.2/audio');

        // $flask_url = "http://18.199.42.2/audio_new/". strval($request->user()->autocalibration);
        $flask_url = "https://3.65.27.242/audio_new/". strval($request->user()->autocalibration);
    
        $response = Http::get($flask_url);

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
                'sharpness_S' => null,
                'loudness_N' => null,
                'roughtness_R' => null,
                'fluctuation_strength_F' => null,
                // 'flask_url' => $flask_url,
            ],
            Response::HTTP_OK
        );
    }
}

