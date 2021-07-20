<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;     

class CartFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cart::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = User::all()->pluck('id')->toArray();
        $product_id = Product::all()->pluck('id')->toArray();
        return [
            'user_id' => Arr::random($user_id),
            'product_id' => Arr::random($product_id),
            'qty' => rand(1,100)
        ];
    }
}
