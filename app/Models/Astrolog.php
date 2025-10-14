<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Astrolog extends Model
{
    use HasFactory;
    
     protected $fillable = [
        'communication_id',
        'type',
        'descreption',
       
    ];
}
