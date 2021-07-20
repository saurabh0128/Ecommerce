<?php

namespace Database\Factories;

use App\Models\RoleHasPermission;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class RoleHasPermissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RoleHasPermission::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $permission_id = Permission::all()->pluck('id')->toArray(); 
        $role_id = Role::all()->pluck('id')->toArray(); 
        return [
            'permission_id' => Arr::random($permission_id),
            'role_id' => Arr::random($role_id)
        ];
    }
}
