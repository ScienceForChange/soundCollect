<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ObservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'observation',
            'id' => $this->id,
            'attributes' => [
                'Leq' => $this->Leq,
                'LAeqT' => $this->LAeqT,
                'LAmax' => $this->LAmax,
                'LAmin' => $this->LAmin,
                'L90' => $this->L90,
                'L10' => $this->L10,
                'sharpness_S' => $this->sharpness_S,
                'loudness_N' => $this->loudness_N,
                'roughtness_R' => $this->roughtness_R,
                'fluctuation_strength_F' => $this->fluctuation_strength_F,
                'images' => $this->images,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'quiet' => $this->quiet,
                'cleanliness' => $this->cleanliness,
                'accessibility' => $this->accessibility,
                'safety' => $this->safety,
                'influence' => $this->influence,
                'landmark' => $this->landmark,
                'protection' => $this->protection,
                'user_id' => $this->user_id,
                'created_at' => $this->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            ],
            'relationships' => [
                'user' => UserResource::make($this->user),
                'types' => TypeResource::collection($this->types),
            ],
        ];
    }
}
