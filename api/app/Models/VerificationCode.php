<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'otp', 'type', 'expire_at', 'is_used'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
