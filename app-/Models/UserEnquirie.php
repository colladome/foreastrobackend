<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UserEnquirie extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'vendor_id',
        'vendor_business_category_detail_id',
        'category_id',
        'name',
        'email',
        'number_of_room',
        'number_of_guest',
        'booking_date',
        'function_type',
        'function_time',
        'notify_me_on_whatsapp',
        'status'
    ];

    protected $casts = [
        'booking_date' => 'array',
    ];
}
