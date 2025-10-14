<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AstrologerLive extends Model
{
    use HasFactory;

    protected $fillable = [
        'astrologer_id',
        'live_id',
        'time',
        'amount',
        'astrologer_live_charges_per_min',

    ];


    public function astrologer()
    {
        return $this->belongsTo(Astrologer::class);
    }
}
