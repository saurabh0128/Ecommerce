<?php

namespace Database\Factories;

use App\Models\Roll;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'roll_name' => $this->faker->name,
            'roll_desc' => $this->faker->text,
            'is_active' => rand(0,1)
        ];
    }
}
