<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponses;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PolylineObservationController extends Controller
{
    public function index()
    {
        try {

            $polyline_observations = DB::table('polyline_observations')->get();

            $response_data = [];
            $path = [];

            // get all polyline items and group them into 'path' array key
            foreach ($polyline_observations as $key => $value) {

                //check if array key exists with give value observation id
                if (array_key_exists($value->observation_id, $path)) {

                    //if exists then append the new value to the array
                    array_push($path[$value->observation_id], array(
                        'start' => [
                            'lat' => $value->start_latitude,
                            'lng' => $value->start_longitude
                        ],
                        'end' => [
                            'lat' => $value->end_latitude,
                            'lng' => $value->end_longitude
                        ],
                        'parameters' => [
                            'L90' => $value->L90,
                            'L10' => $value->L10,
                            'LAmax' => $value->LAmax,
                            'LAmin' => $value->LAmin,
                            'LAeq' => $value->LAeq,
                            // 'LAeqT' => $value->LAeqT
                        ],
                        // 'position' => $value->position
                    ));
                }else{
                    //if not - create new array key
                    $path[$value->observation_id] = [];
                }
            }


            // $all_observations = DB::table('observations')
            //     ->join('polyline_observations', function ($join) {
            //         $join->on('observations.id', '=', 'polyline_observations.observation_id');
            //     })
            //     ->get();


            // select all observations
            $all_observations = DB::table('observations')->get()->toArray();

            $response  = [];

            // append path to all observations array if id matches
            foreach ($all_observations as $all_observations_key => $all_observations_value) {

                $response[$all_observations_value->id] = [];

                foreach ($path as $path_key => $path_value) {

                    if ($path_key == $all_observations_value->id) {

                        array_push($response[$all_observations_value->id], array(
                            // 'observation_id' => $path_value['observation_id'],
                            'id' => $all_observations_value->id,
                            'path' => $path_value,
                            // 'id' => $all_observations_value->id,
                            'user_id' => $all_observations_value->user_id,
                            'images' => $all_observations_value->images,
                            // 'date' => $all_observations_value->date,
                            // 'time' => $all_observations_value->time,
                            // 'duration' => $all_observations_value->duration,
                            // 'weather' => $all_observations_value->weather,
                            'temperature' => $all_observations_value->temperature,
                            'humidity' => $all_observations_value->humidity,
                            // 'wind_speed' => $all_observations_value->wind_speed,
                            // 'wind_direction' => $all_observations_value->wind_direction,
                            // 'pressure' => $all_observations_value->pressure,
                            // 'noise' => $all_observations_value->noise,
                            // 'description' => $all_observations_value->description,
                            'created_at' => $all_observations_value->created_at,
                            // 'updated_at' => $all_observations_value->updated_at,
                            'fluctuation' => $all_observations_value->fluctuation,
                            'wind_speed' => $all_observations_value->wind_speed,
                        ));
                    }
                }
            }

            return new JsonResponse([
                'status' => 'success',
                'data' => $response,
            ], 200);
        } catch (\Throwable $th) {
            return 'General error on polyline observations controller is: ' . $th;
        }
    }
}
