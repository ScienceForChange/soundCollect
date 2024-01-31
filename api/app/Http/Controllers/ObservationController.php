<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteObservationRequest;
use App\Http\Requests\StoreObservationRequest;
use App\Models\Observation;
use Illuminate\Http\Request;
use App\Http\Resources\ObservationResource;
use App\Traits\ApiResponses;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;


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

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreObservationRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $folder = "users/". $request->user()->id;
            foreach ($images as $key => $image) {
                $url_images = Storage::put($folder, $image, 'public');
                Arr::set($validated, 'images.'.$key, $url_images);
            }
        }
        $observation = Observation::create($validated);

        return $this->success(
            new ObservationResource($observation),
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
