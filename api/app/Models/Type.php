<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];
    /**
     * The observations attatched with the type.
     */
    public function observations(): BelongsToMany
    {
        return $this->belongsToMany(Observation::class);
    }
}
