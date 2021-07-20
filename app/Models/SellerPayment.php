<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerPayment extends Model
{
    use HasFactory;
    protected $filable= [
        'user_id',
        'purchase_id',
        'payable_amt',
        'chargable_amt',
        'is_payed',
        'payment_mode',
        'transaction_no',
    ];
}   
