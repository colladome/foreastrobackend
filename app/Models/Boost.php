<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boost extends Model
{
    use HasFactory;
    protected $fillable = [
        'astrologer_id',
        'amount',

    ];

    public function astrologer()
        {
            return $this->belongsTo(Astrologer::class);
        }
}
