<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'order_id',
        'vendor_id',
        'vendor_business_category_detail_id',
        'category_id',
        'number_of_room',
        'number_of_guest',
        'booking_date',
        'function_type',
        'function_time',
        'product_name',
        'price',
        'image',
        'status',
        'vendor_view_status'
    ];

    protected $casts = [
        'booking_date' => 'array',
        'image' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class,);
    }
}
