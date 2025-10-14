<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AstrologerCoupon extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'astrologer_id',
        'coupon_id',
        'type',
    ];
}
