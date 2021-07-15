<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Carbon\carbon;

class backendRollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rolls')->insert([
            'roll_name' => "Admin",
            'roll_desc' => "I am Admin",
            'is_active' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')

        ]);
    }
}
