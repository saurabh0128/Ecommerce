<?php

namespace Database\Factories;

use App\Models\Roll;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;


class RollFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Roll::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $str = ["Admin","Seller","User"];
        return [
            'roll_name' => Arr::random($str),
            'roll_desc' => $this->faker->text,
            'is_active' => rand(0, 1)
        ];
    }
}
