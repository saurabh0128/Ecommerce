<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupone extends Model
{
    use HasFactory;
    protected $table = 'coupons';

    protected $filable = [
        'coupon_code',
        'coupon_details',
        'coupon_discount',
        'coupon_type',
        'dicount_type',
        'start_date',
        'end_date',
        'total_uses'
    ];

    public function purchase()
    {
        return $this->hasMany(purchase::class,'coupon_id');
    }
}
