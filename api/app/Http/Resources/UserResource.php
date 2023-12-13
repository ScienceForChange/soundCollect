<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => $this->getProfileTypeAttribute(),
            'uuid' => $this->uuid,
            'attributes' => [
                'email' => $this->when($request->user()?->uuid === $this->uuid, $this->email),
                'avatar' => $this->avatar_id,
                'profile' => new ProfileCitizenResource($this->profile),
                'created_at' => $this->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            ],
            'links' => [
                'self' => route('users.show', ['uuid' => $this->uuid]),
            ],
            'relationships' => [
                //
            ],
        ];
    }
}
