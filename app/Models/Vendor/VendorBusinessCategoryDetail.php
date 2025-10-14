<?php

namespace App\Models\Vendor;

use App\Models\Backend\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Vendor\VendorVenueSpace;
use App\Models\Vendor\VendorCategoryProfile;
use App\Models\Wishlist;

class VendorBusinessCategoryDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'category_id',
        'venue_criteria',
        'vendor_category_profile_id',
        'number_of_room_available',
        'parking_availability_detial',
        'ac_availability_detial',
        'alcohol_allowed_detial',
        'is_photography',
        'is_videography',
        'is_your_venue_pure_vegetarian_detial',
        'inhouse_catering_only_detial',
        'maximum_capacity',
        'cuisine_type',
        'per_plate_veg_price',
        'per_plate_non_veg_price',
        'min_price',
        'is_trial_makeup',
        'is_trial_makeup_free',
        'makeup_trail_price',
        'bride_makeup_price',
        'family_makeup_price',
        'groom_makeup_price',
        'makeup_description',
    ];


    protected $casts = [
        'venue_criteria' => 'array',
        'cuisine_type' => 'array',
    ];



    public function venueSpaces()
    {
        return $this->hasMany(VendorVenueSpace::class);
    }

    public function vendorBusinessProfile()
    {
        return $this->belongsTo(VendorCategoryProfile::class, 'vendor_category_profile_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function wishlist()
    {
        return $this->hasOne(Wishlist::class);
    }
}
