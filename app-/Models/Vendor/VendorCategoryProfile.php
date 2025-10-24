<?php

namespace App\Models\Vendor;

use App\Models\Backend\Category;
use App\Models\Backend\City;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class VendorCategoryProfile extends Model
{

    use HasFactory, SoftDeletes;
    protected $table = 'vendor_category_profiles';
    protected $fillable = [
        'user_id',
        'category_id',
        'state_id',
        'city_id',
        'area_id',
        'business_profile_name',
        'contact_number',
        'address',
        'pin_code',
        'location_link',
        'listing_cover_image',

    ];

    protected $casts = [
        'listing_cover_image' => 'array',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }


    public function vendorBusinessCategoryDetail()
    {
        return $this->hasOne(VendorBusinessCategoryDetail::class);
    }
}
