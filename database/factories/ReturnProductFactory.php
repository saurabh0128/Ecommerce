<?php

namespace Database\Factories;

use App\Models\ReturnProduct;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class ReturnProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ReturnProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $purchase_id = Purchase::all()->pluck('id')->toArray();
        return [
            'purchase_id' => Arr::random($purchase_id),
            'is_return' => rand(0,1),
            'is_refunded' => rand(0,1)
        ];
    }
}
