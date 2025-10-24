<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'otp_secret', 'expires_at', 'verified_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired()
    {
        return now()->gte($this->expires_at);
    }

    public function markAsVerified()
    {
        $this->update(['verified_at' => now()]);
    }
}
