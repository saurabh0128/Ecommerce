<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $filable = [
        'user_id',
        'address_line_1',
        'address_line_2',
        'landmark',
        'pincode',
        'city_id',
         

    ];
}
