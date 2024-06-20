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
            
            foreach ($polyline_observations as $key => $value) {
                array_push($response_data, [
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
                        'LAeqT' => $value->LAeqT
                    ],
                    'observation_id' => $value->observation_id,
                    'position' => $value->position
                ]);
            }
            

            $all_observations = DB::table('observations')
                ->join('polyline_observations', function ($join) {
                    $join->on('observations.id', '=', 'polyline_observations.observation_id');
                })
                ->get();

            // foreach ($all_observations as $key => $value) {

            //     foreach ($response_data as $response_data_key => $response_data_value) {

            //         if ($value->id == $response_data_value['observation_id']) {
            //             $response_data[$response_data_key]['polyline_observations']['path'] = [
            //                 'start' => [
            //                     'lat' => $value->start_latitude,
            //                     'lng' => $value->start_longitude
            //                 ],
            //                 'end' => [
            //                     'lat' => $value->end_latitude,
            //                     'lng' => $value->end_longitude
            //                 ],
            //                 'parameters' => [
            //                     'L90' => $value->L90,
            //                     'L10' => $value->L10,
            //                     'LAmax' => $value->LAmax,
            //                     'LAmin' => $value->LAmin,
            //                     'LAeq' => $value->LAeq,
            //                     'LAeqT' => $value->LAeqT
            //                 ],
            //                 'observation_id' => $value->observation_id,
            //                 'position' => $value->position
            //             ];
            //         }

            //     }

                // array_push($response_data[$value->id], [
                //     'start' => [
                //         'lat' => $value->start_latitude,
                //         'lng' => $value->start_longitude
                //     ],
                //     'end' => [
                //         'lat' => $value->end_latitude,
                //         'lng' => $value->end_longitude
                //     ],
                //     'parameters' => [
                //         'L90' => $value->L90,
                //         'L10' => $value->L10,
                //         'LAmax' => $value->LAmax,
                //         'LAmin' => $value->LAmin,
                //         'LAeq' => $value->LAeq,
                //         'LAeqT' => $value->LAeqT
                //     ],
                //     'observation_id' => $value->observation_id,
                //     'position' => $value->position
                // ]);
            // }

            return new JsonResponse([
                'status' => 'success',
                'data' => $response_data,
            ], 200);

        } catch (\Throwable $th) {
            return 'General error on polyline observations controller is: ' . $th;
        }
    }
}
