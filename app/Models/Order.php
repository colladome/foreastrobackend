<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'billing_name',
        'billing_email',
        'number_of_item',
        'billing_address',
        'billing_address2',
        'state',
        'city',
        'zip',
        'total_amount',
        'payment_status',
        'order_status'
    ];

    public function order()
    {
        return $this->hasMany(OrderItem::class);
    }
}
