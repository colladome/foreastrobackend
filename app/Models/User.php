<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Backend\Category;
use App\Models\UserProfile;
use Spatie\Permission\Traits\HasRoles;



use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile_number',
        'user_type',
        'gender',
        'sign',
        'address',
        'state',
        'date_of_birth',
        'birth_time',
        'city',
        'pincode',
        'profile_img',
        'email_verified_at',
        'is_profile_created',
        'password',
        'gauth_id',
        'socail_media_auth_type',
        'facebook_auth_id',
        'notifaction_token',
        'trusted',
        'wallet',
        'version',
        'status',
        'is_bonus'
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




    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * user profile deatils
     */


    public function userProfile()
    {

        return $this->hasOne(UserProfile::class);
    }
}
