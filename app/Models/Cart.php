<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $filable = [
        'user_id',
        'subtotal',
        'discount',
        'discount_percentage',
        'coupon_id',
        'shipping_charges',
        'total',
    ];
    public function CartItem()
    {
        return $this->hasMany(CartItem::class,'cart_id');
    }
    public function Coupone()
    {
        return $this->belongsTo(Coupone::class,'coupon_id');
    }
}
