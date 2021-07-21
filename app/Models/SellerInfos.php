<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerInfos extends Model
{
    use HasFactory;

    protected $filable = [
        'user_id',
        'gst_no',
        'company_name',
        'address',
        'city_id',
        'bank_name',
        'account_no',
        'ifsc_code',
        'ac_holder_name',
        'id_proof_no',
        'id_proof',
        'is_permisssion_sell',
    ];
}