<?php

namespace App\Models\Backend;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'image',
        'description',
        'order',
        'status'
    ];

    protected $casts = [
        'image' => 'array',
    ];


    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
