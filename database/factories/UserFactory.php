<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Roll;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'name' => $this->faker->name,
            'user_name' => $this->faker->name,
            'phone_no' => $this->faker->numerify('##########'),
            'email_id' => $this->faker->email,
            'password' => bcrypt('Saurabh@123'),
            'profile_img' => Str::slug($this->faker->name),
            'user_status' => rand(0,1),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
