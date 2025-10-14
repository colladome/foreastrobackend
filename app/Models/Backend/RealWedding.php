<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RealWedding extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'cover_image',
        'vendor_id',
        'photos',
        'description',
        'place',
        'status'
    ];

    protected $casts = [
        'cover_image' => 'array',
        'photos' => 'array',
    ];
}
