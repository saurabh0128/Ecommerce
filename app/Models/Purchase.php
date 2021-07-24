<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $filable = [
        'customer_name',
        'user_id',
        'user_address_id',
        'billing_address_id',
        'coupon_id',
        'shipping_amt',
        'total_amt',
        'is_payed',
        'payment_mode',
        'transaction_no',
        'purchase_date',
        'delivery_date',
        'delivery_status',
        'purchase_status',
    ];

    public function user()
    {
       return $this->belongsTo(User::class,'user_id');     
    }

    public function user_address()
    {
        return $this->belongsTo(UserAddress::class,'user_address_id'); 
    }

    public function billing_address()
    {
        return $this->belongsTo(UserAddress::class,'billing_address_id'); 
    }

    public function coupon()
    {
        return $this->belongsTo(Coupone::class,'coupon_id'); 
    }

    public function purchase_item()
    {
        return $this->hasMany(PurchaseItems::class,'purchase_id');
    }
}
