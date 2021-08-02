<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = "categorys";
    protected $filable = [
        'category_name'
    ];


    public function product()
    {
        return $this->hasMany(Product::class,'category_id');      
    }
    public function users()
    {
        return $this->belongsToMany(User::class);   
    }

    public function Parent_Category()
    {
        return $this->belongsTo(self::class,'parent_category_id');
    }

    public function sub_category()
    {
        return $this->hasMany(self::class,'parent_category_id');
    }
}
