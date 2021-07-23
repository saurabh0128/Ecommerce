<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
}
