<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $filable = [
        'cookie',
        'auth_user',
        'subtotal',
        'discount',
        'discount_percentage',
        'coupon_id',
        'shipping_charges',
        'net_total',
        'tax',
        'total',
        'round_off',
        'payable',
    ];
}
