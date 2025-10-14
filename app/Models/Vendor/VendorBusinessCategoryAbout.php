<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class VendorBusinessCategoryAbout extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'category_id',
        'about_section',
        'is_price_negotiable',
        'usp_feature',
        'award_and_recognition',
        'payment_policy',
        'cancellation_policy',
    ];
}
