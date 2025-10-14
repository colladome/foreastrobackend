<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Backend\Category;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'image',
        'meta_description',
        'meta_title',
        'slug',
        'status'
    ];


    protected $casts = [
        'image' => 'array',
    ];

    // public function category()
    // {
    //     return $this->belongsTo(Category::class);
    // }
}
