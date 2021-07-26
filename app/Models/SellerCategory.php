<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class SellerCategory extends Model
{
    use HasFactory;

    protected $table = "seller_categorys";
    protected $filable = [
        'user_id',
        'category_id',
    ];
    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }
   /* public function category()
    {
        return $this->hasMany(Category::class,'category_id');
    }*/
}
