<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileCitizenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'profile_citizen',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'gender' => $this->gender,
                'birthYear' => $this->birth_year,
                'statusSentence' => $this->status_sentence,
                'deletedBecause' => $this->deleted_because,
            ],
        ];
    }
}
