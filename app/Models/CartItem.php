<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $filable = [
        'cart_id',
        'product_id',
        'name',
        'price',
        'image',
        'quantity',
    ];
    public function Cart()
    {
        return $this->belongsTo(Cart::class,'cart_id');
    }
    
}
