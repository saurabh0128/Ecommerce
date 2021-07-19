<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roll extends Model
{
    use HasFactory;

    protected $filable = [
        'roll_name',
        'roll_desc',
        'is_active'
    ];
}
