<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'citys';

    protected $filable = [
        'city_name',
        'state_id'

    ];
    public function sellerinfos()
    {
        return $this->hasMany(SellerInfos::class,'city_id');
    }
    public function userAddress()
    {
        return $this->hasMany(UserAddress::class,'city_id');
    }
}
