<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $filable = [
        'name',
        'guard_name',
    ];

    public function permission()
    {
        return $this->belongsToMany(permission::class,'role_has_permissions','role_id','permission_id');
    }
}
