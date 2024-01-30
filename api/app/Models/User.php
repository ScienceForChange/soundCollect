<?php

namespace App\Models;

use App\Notifications\NewPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['profile'];

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'uuid';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'avatar_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the parent userable model (citizen profile, client profile, etc).
     */
    public function profile(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'profile_type', 'profile_id');
    }

    /**
     * Get user´s profile type
     */
    public function getProfileTypeAttribute(): string
    {
        return $this->profile->getMorphClass();
    }

    public function activeOtp()
    {
        return $this->otp()->where('expire_at', '>', Carbon::now())->where('is_used', false)->first();
    }

    public function otp(): HasMany
    {
        return $this->hasMany(VerificationCode::class);
    }

    public function sendEmailOtpNotification(VerificationCode $otp): void
    {
        $this->notify(new \App\Notifications\Otp($otp));
    }

    public function sendNewPasswordNotification($newPassword): void
    {
        $this->notify(new NewPassword($newPassword));
    }
}
