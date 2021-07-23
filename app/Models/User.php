<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\SellerInfos;

class User extends Authenticatable
{
    use HasFactory;

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
   /* public static function boot()
    {
        parent::boot();

        static::deleting(function($user){
            $user->seller_infos()->delete();

        });
    }
   */ 
}
