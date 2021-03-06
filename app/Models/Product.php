<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Freshbitsweb\LaravelCartManager\Traits\Cartable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $filable= [
        'product_name',
        'product_desc',
        'product_img',
        'current_price',
        'special_price',
        'category_id',
        'user_id',
        'is_display',
        'is_avilable',
        'stock',   

    ];

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function rating_review(){
        return $this->hasMany(RatingReview::class,'product_id');
    }

    public function cart_item(){
        return $this->hasMany(CartItem::class,'product_id');
    }
    public function wishlist()
    {
        return $this->hasMany(wishlist::class,'product_id');
    }
    public function purchase_item()
    {
        return $this->hasMany(PurchaseItems::class,'product_id');
    }
}
