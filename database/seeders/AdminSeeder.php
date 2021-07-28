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
            "id" => 1,
            "name" => "SuperAdmin",
            "user_name"=> "superadmin",
            "phone_no" => 8878459696,
            "email_id" => "admin@admin.com",
            "password" => Hash::make('secret'),
            "profile_img" => "https://dummyimage.com/300",
            "user_status" => 2
        ]);
    }
}
