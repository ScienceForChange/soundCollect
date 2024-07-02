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

        try {
            // write the audio file on flask server to convert it into parameters 
            try {
                Storage::disk('sftp_to_new_flask_2cpu')->putFileAs('/home/ubuntu/SoundCollect_flask/audio', $request->audio, 'audio_to_process.WAV');
            } catch (\Exception $e) {
                return $this->error('Error when saving audio: ' . $e, Response::HTTP_INTERNAL_SERVER_ERROR);
            }


            // Create user named folder on the flask server (with email name before @) and save audio file into it
            try {
                Storage::disk('sftp_to_new_flask_2cpu')->putFileAs('/home/ubuntu/SoundCollect_flask/audio/' . strstr($request->user()->email, '@', true), $request->audio, "audio-" . str_replace(' ', '-', now()->toDateTimeString()) . ".WAV");
            } catch (\Exception $e) {
                return $this->error('Error when trying to create user named folder to save audio.' . $e, Response::HTTP_INTERNAL_SERVER_ERROR);
            }


            // define url to call audio to params function on flask server
            $flask_url = "https://soundcollectflask.com/audio_new/" . strval($request->user()->autocalibration);


            // call audio to params funcion on flask server
            try {
                $response = Http::get($flask_url);
            } catch (\Exception $e) {
                return $this->error('Error when calling flask audio to parameters function on flask sever: ' . $e, Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            // return $this->success('response from flask is: ' . $response , 200);

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
                    'sharpness_S' => round($data->sharpness, 2),
                    'loudness_N' => round($data->loudness,2),
                    'roughtness_R' => null, // Todavía no se calcula
                    'fluctuation_strength_F' => round($data->fluctuation, 5), // Tiene muchos decimales, aún esta por ver cómo se guarda
                    // 'flask_url' => $flask_url,
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return $this->error('General error when processing audio is: ' . $th, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
