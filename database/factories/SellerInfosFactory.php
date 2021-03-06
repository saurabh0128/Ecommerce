<?php

namespace Database\Factories;

use App\Models\SellerInfos;
use App\Models\User;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;


class SellerInfosFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SellerInfos::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = User::all()->pluck('id')->toArray();
        $city_id = City::all()->pluck('id')->toArray();
        return [
            'user_id' => Arr::random($user_id),
            'gst_no' => Str::random(15),
            'company_name' => $this->faker->name,
            'address' => $this->faker->text,
            'city_id' => Arr::random($city_id),
            'bank_name' => $this->faker->name,
            'account_no' => $this->faker->numerify('##############'),
            'ifsc_code' => Str::random(6),
            'ac_holder_name' => $this->faker->name,
            'id_proof_no' => $this->faker->numerify('#############'),
            'id_proof' => $this->faker->imageUrl(100,200),  
            'is_permisssion_sell' => rand(0,1)
        ];
    }
}
