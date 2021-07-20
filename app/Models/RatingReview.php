<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingReview extends Model
{
    use HasFactory;

    protected $filable = [
        'purchase_id',
        'rating',
        'review',
        'is_display'
    ];
}
