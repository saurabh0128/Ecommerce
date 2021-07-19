<?php

namespace Database\Factories;

use App\Models\UserAddress;
use App\Models\User;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class UserAddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::all()->pluck('id')->toArray();
        $city = City::all()->pluck('id')->toArray();
        return [
            'user_id' => Arr::random($user),
            'address_line_1' => $this->faker->text,
            'address_line_2' => $this->faker->text,
            'landmark' => $this->faker->name,
            'pincode' => $this->faker->numerify('######'),
            'city_id' => Arr::random($city),
        ];
    }
}
