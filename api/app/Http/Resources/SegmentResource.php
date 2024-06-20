<?php

// create segment resource
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SegmentResource extends JsonResource
{
    public function toArray()
    {
        return [
            'id' => $this->id,
            // 'start' => $this->start,
            // 'end' => $this->end,
            // 'observations' => $this->observations
        ];
    }
}