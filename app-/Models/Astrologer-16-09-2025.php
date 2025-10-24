<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Contracts\Auth\Authenticatable;

class Astrologer extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'mobile_number',
        'user_type',
        'gender',
        'adhar_id',
        'pan_number',
        'specialization',
        'date_of_birth',
        'birth_place',
        'experience',
        'call_charges_per_min',
        'chat_charges_per_min',
        'languaage',
        'address',
        'state',
        'city',
        'pin_code',
        'profile_img',
        'total_rating',
        'profile_status',
        'email_verified_at',
        'is_profile_created',
        'password',
        'gauth_id',
        'gauth_id',
        'education',
        'description',
        'commission_percent',
        'notifaction_token',
        'commission_descreption',
        'start_time_slot',
        'end_time_slot',
        'version',
        'video_charges_per_min',
        'trusted',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'languaage' => 'array',

    ];
}
