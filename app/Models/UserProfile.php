<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UserProfile extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'state_id',
        'city_id',
        'area_id',
        'address',
        'pin_code',
        'alternate_mobile',
        'avtar',
	    ];


        protected $casts = [
            'avtar' => 'array',
        ];
}
