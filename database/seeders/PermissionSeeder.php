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
        $permission = Permission::create(['name' => 'Add products'],['name'=> 'Edit Products'],['name' => 'View Sellers'] ,['name' => 'Add Sellers' ],['name'=> 'View Products'],['name'=>'Delete Users'],['name'=>'Edit Users'],['name'=>'View Users'],['name' =>'Delete Products'],['name'=>'Add Users']);

        // $permission = Permission::all()->pluck('name');

        $role = Role::where('name','SuperAdmin')->first();
        $role->givePermissionTo($permission);

        $user = User::find(1);
        $user->assignRole('SuperAdmin');
        
    }
}
