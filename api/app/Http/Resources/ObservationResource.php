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
                'audio_param_1' => $this->audio_param_1,
                'audio_param_2' => $this->audio_param_2,
                'audio_param_3' => $this->audio_param_3,
                'audio_param_4' => $this->audio_param_4,
                'images' => $this->images,
                'sound_type' => $this->sound_type,
                'sound_source' => $this->sound_source,
                'sound_perception_enviroment' => $this->sound_perception_enviroment,
                'comments' => $this->comments,
                'created_at' => $this->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            ],
            'relationships' => [
                'user' => UserResource::make($this->whenLoaded('user')),
            ],
        ];
    }
}
