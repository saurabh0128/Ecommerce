<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $filable=[
        'StateName'
    ];

    public function city()
    {
       return $this->hasMany(City::class,'state_id');     
    }

}
