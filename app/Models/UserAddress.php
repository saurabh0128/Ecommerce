<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $filable = [
        'user_id',
        'address_line_1',
        'address_line_2',
        'landmark',
        'pincode',
        'city_id',
    ];

    public function purchase()
    {
        return $this->hasMany(Purchase::class,'user_address_id');
    }

    public function purchase_bill()
    {
        return $this->hasMany(Purchase::class,'billing_address_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
