<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Area extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'state_id',
        'city_id',
        'name',
	    ];
}
