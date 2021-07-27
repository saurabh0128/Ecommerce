<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $filable = [
        'name',
        'guard_name',
    ];

    public function role()
    {
        return $this->belongsToMany(role::class,'role_has_permissions','permission_id','role_id');
    }
}
