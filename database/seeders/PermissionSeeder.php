<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = Permission::create(['name' => 'Add Products']);
        $permission = Permission::create(['name' => 'Edit Products']);
        $permission = Permission::create(['name' => 'View Sellers']);
        $permission = Permission::create(['name' => 'Add Sellers']);
        $permission = Permission::create(['name' => 'View Products']);
        $permission = Permission::create(['name' => 'Delete Users']);
        $permission = Permission::create(['name' => 'Edit Users']);
        $permission = Permission::create(['name' => 'View Users']);
        $permission = Permission::create(['name' => 'Add Users']);
        $permission = Permission::create(['name' => 'View Role Permissions']);
        $permission = Permission::create(['name' => 'Edit Role Permissions']);
        $permission = Permission::create(['name' => 'Add Role Permissions']);
        $permission = Permission::create(['name' => 'View Dashboard']);
        $permission = Permission::create(['name' => 'Add Roles']);
        $permission = Permission::create(['name' => 'View Roles']);
        $permission = Permission::create(['name' => 'Edit Roles']);
        $permission = Permission::create(['name' => 'Delete Roles']);
        $permission = Permission::create(['name' => 'View Permissions']);
        $permission = Permission::create(['name' => 'Add Permissions']);
        $permission = Permission::create(['name' => 'Edit Permissions']);
        $permission = Permission::create(['name' => 'Delete Permissions']);
        $permission = Permission::create(['name' => 'Edit Sellers']);
        $permission = Permission::create(['name' => 'Delete Sellers']);
        $permission = Permission::create(['name' => 'Add Categories']);
        $permission = Permission::create(['name' => 'View Categories']);
        $permission = Permission::create(['name' => 'Edit Categories']);
        $permission = Permission::create(['name' => 'Delete Categories']);
        $permission = Permission::create(['name' => 'Add Coupons']);
        $permission = Permission::create(['name' => 'Edit Coupons']);
        $permission = Permission::create(['name' => 'View Coupons']);
        $permission = Permission::create(['name' => 'View Rating Reviews']);
        $permission = Permission::create(['name' => 'View Locations']);
        $permission = Permission::create(['name' => 'View Notification']);
        $permission = Permission::create(['name' => 'View Orders']);
        $permission = Permission::create(['name' => 'Delete Orders']);
        $permission = Permission::create(['name' => 'Add Orders']);
      
         

        $all_permission = Permission::all()->pluck('name');

        $role = Role::where('name','SuperAdmin')->first();
        $role->givePermissionTo($all_permission);

        $user = User::find(1);
        $user->assignRole('SuperAdmin');
        
    }
}
