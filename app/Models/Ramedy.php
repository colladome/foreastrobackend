<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ramedy extends Model
{
    use HasFactory;
    protected $fillable = [
        'astrologer_id',
        'description',
    ];
}
