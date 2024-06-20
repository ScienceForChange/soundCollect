<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PolylineResource extends JsonResource
{
    public function toArray()
    {
        return [
            // Define the attributes you want to include in the resource
            'id' => $this->id,
            // 'name' => $this->name,
            // 'coordinates' => $this->coordinates,
            // Add any other attributes you need
        ];
    }
}
