<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class roll extends Model
{
    use HasFactory;

    protected $fillable =[
        'roll_name',
        'roll_desc',
        'is_active'
    ];
}
