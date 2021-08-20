<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\SellerInfos;
use App\Models\UserAddress;
use App\Models\Category;
use App\Models\SellerCategory;
use Laravel\Passport\HasApiTokens;

use Spatie\Permission\Traits\HasRoles;

use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory,HasRoles,HasApiTokens,Notifiable;
    
    protected $filable = [
        'name',
        'user_name',
        'phone_no',
        'email_id',
        'password',
        'profile_img',
        'user_status'   
    ];

    
    public function seller_infos()
    {
        return $this->hasOne(SellerInfos::class,'user_id');
    }
   /* public function useraddress()
    {
        return $this->hasMany(UserAddress::class,'user_id');
    }*/
   
   /* public static function boot()
    {
        parent::boot();

        static::deleting(function($user){
            $user->seller_infos()->delete();

        });
    }
   */ 

    public function product()
    {
        return $this->hasMany(Product::class,'user_id');      
    }


    public function purchase()
    {
        return $this->hasMany(Purchase::class,'user_id');
    }

    public function userAddress(){
        return $this->hasMany(UserAddress::class,'user_id');
    }
    public function category()
    {
        return $this->belongsToMany(Category::class,'Seller_Categorys','user_id','category_id');
    }

    public function rating_review(){
        return $this->hasMany(RatingReview::class,'user_id');
    }

    public function role()
    {
        return $this->belongsToMany(role::class,'model_has_roles','model_id','role_id');
    }
    
}
