<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AstroOtp extends Model
{
    use HasFactory;
    protected $fillable = ['astrologer_id', 'otp_secret', 'expires_at', 'verified_at'];

    public function astrologer()
    {
        return $this->belongsTo(Astrologer::class);
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
