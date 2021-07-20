<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerCategory extends Model
{
    use HasFactory;

    protected $table = "seller_categorys";
    protected $filable = [
        'user_id',
        'category_id',
    ];
}
