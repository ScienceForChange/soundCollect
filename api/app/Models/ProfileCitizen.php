<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ProfileCitizen extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'birth_year',
        'status_sentence',
        'deleted_because'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_year' => 'date',
    ];

    /**
     * Get the user's profile.
     */
    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'profile');
    }
}
