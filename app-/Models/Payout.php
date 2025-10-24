<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    use HasFactory;
    protected $fillable = [
        'astrologer_id',
        'total_amount',
        'commission_amount',
        'live_amount',
        'paid_amount',
        'communication_id',
        'live_id',
        'payment_status',
        'total_coupon_discount',
        'credit_amount',
        'weekly_start_date',
        'weekly_end_date'
    ];

    protected $casts = [
        'communication_id' => 'array',
        'live_id' => 'array',
        'boost_id' => 'array',
    ];


    public function astrologer()
    {
        return $this->belongsTo(Astrologer::class);
    }
}
