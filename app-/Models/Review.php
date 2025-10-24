<?php

namespace App\Models;

use App\Models\Backend\Category;
use App\Models\Vendor\VendorBusinessCategoryDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'astrologer_id',
        'comment',
        'rating',
        'status'
    ];

    public function astrologer()
    {
        return $this->belongsTo(Astrologer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
