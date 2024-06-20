<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Segment extends Model
{
    // segments have hasmany relationship with observations
    public function observation()
    {
        return $this->belongsTo(Observation::class);
    }
}
