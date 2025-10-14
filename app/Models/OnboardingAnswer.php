<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class OnboardingAnswer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'astrologer_id',
        'question',
        'answer',
    ];

    public function astrologer()
    {
        return $this->belongsTo(Astrologer::class);
    }
}
