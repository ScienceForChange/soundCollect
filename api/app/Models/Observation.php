<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Observation extends Model
{
    use HasFactory;

    protected $fillable = [
        'audio_param_1',
        'audio_param_2',
        'audio_param_3',
        'audio_param_4',
        'images',
        'sound_type',
        'sound_source',
        'sound_perception_enviroment',
        'comments',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
