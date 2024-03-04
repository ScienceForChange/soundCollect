<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteObservationRequest;
use App\Http\Requests\StoreObservationRequest;
use App\Models\Observation;
use Illuminate\Http\Request;
use App\Http\Resources\ObservationResource;
use App\Http\Resources\UserObservationsResource;
use App\Traits\ApiResponses;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class ObservationController extends Controller
{
    use ApiResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success(
            ObservationResource::collection(Observation::all()),
            Response::HTTP_OK
        );
    }

    public function userObservations(Request $request)
    {
        return $this->success(
            UserObservationsResource::collection($request->user()->observations),
            Response::HTTP_OK
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreObservationRequest $request)
    {
        $validated = $request->validated();

        //return $validated;

        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $folder = "users/". $request->user()->id;
            foreach ($images as $key => $image) {
                $url_images = Storage::put($folder, $image, 'public');
                Arr::set($validated, 'images.'.$key, 'https://soundcollectbucket.s3.eu-central-1.amazonaws.com/'.$url_images);
            }
        }

        $response = Http::get(config('services.openweathermap.url'), [
            'lat' => $validated['latitude'],
            'lon' => $validated['longitude'],
            'appid' => config('services.openweathermap.key'),
            'units' => config('services.openweathermap.units'),
        ]);

        $data = $response->object();

        // dd('wind-speed:'. $data->wind->speed,
        //     'humidity:'.$data->main->humidity,
        //     'temperature:'. $data->main->temp,
        //     'pressure:'. $data->main->pressure);

        $validated = Arr::add($validated, 'wind_speed', $data->wind->speed);
        $validated = Arr::add($validated, 'humidity', $data->main->humidity);
        $validated = Arr::add($validated, 'temperature', $data->main->temp);
        $validated = Arr::add($validated, 'pressure', $data->main->pressure);

        $observation = Observation::create($validated);
        $observation->types()->attach($validated['sound_types']);

        return $this->success(
            new ObservationResource($observation->fresh()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Observation $observation)
    {
        return $this->success(
            new ObservationResource($observation),
            Response::HTTP_OK
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Observation $observation)
    {
        return 'update';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Observation $observation)
    {
        if($observation->user_id !== auth()->user()->id){
            return $this->error(
                'You can only delete your own observations',
                Response::HTTP_UNAUTHORIZED
            );
        }

        $observation->delete();

        return $this->success(
            $observation->id,
            Response::HTTP_OK
        );
    }
}
