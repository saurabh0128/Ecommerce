<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;

use Carbon\carbon;

use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'bhargav',
            'user_name' => 'admin_bhargav',
            'phone_no' => '8849032844',
            'email_id' => 'bhargav121@gmail.com',
            'password' => Hash::make('bhargav123'),
            'profile_img' =>  'https://source.unsplash.com/random',
            'roll_id' => 1,
            'is_verified' => 0,
            'is_block' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
