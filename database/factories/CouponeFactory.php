<?php

namespace Database\Factories;

use App\Models\Coupone;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\carbon;

class CouponeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Coupone::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'coupon_code' => $this->faker->name,
            'coupon_details' => $this->faker->text,
            'coupon_discount' => rand(1,100),
            'coupon_type' => $this->faker->name,
            'dicount_type' => $this->faker->name,
            'start_date' => Carbon::parse(now())->format(env('APP_DATE_FORMAT')),   
            'end_date' => Carbon::parse(now())->format(env('APP_DATE_FORMAT')),
            'total_uses' => $this->faker->numerify('###'),
        ];
    }
}
