<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class VendorVenueSpace extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_business_category_detail_id',
        'space_name',
        'venue_suitable',
        'seating_pax',
        'venu_type',
        'venue_rent',
        'lawn_availability',
        'parking_availability',
        'ac_availability',
        'inside_alcohol_permission',
        'permission_to_acquire_outside_alchohol',
        'alcohol_allowed',
    ];

    protected $casts = [
        'venue_suitable' => 'array',
    ];
}
