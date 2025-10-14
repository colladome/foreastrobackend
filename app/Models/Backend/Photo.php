<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'cover_image',
        'photos',
        'place',
        'status'
    ];

    protected $casts = [
        'cover_image' => 'array',
        'photos' => 'array',
    ];
}
