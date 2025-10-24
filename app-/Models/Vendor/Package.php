<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'category_id',
        'vendor_category_profile_id',
        'title',
        'image_path',
        'description',
        'price',
        'slug',
        'status'
    ];

    protected $casts = [
        'image_path' => 'array',
    ];

    public function vendorBusinessProfile()
    {
        return $this->belongsTo(VendorCategoryProfile::class, 'vendor_category_profile_id');
    }
}
