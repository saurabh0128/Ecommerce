<?php

namespace Database\Factories;

use App\Models\PurchaseItems;
use App\Models\Purchase;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class PurchaseItemsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PurchaseItems::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $purchase = Purchase::all()->pluck('id')->toArray();
        $product = Product::all()->pluck('id')->toArray();
        return [
            'purchase_id' => Arr::random($purchase),
            'product_id' => Arr::random($product),
            'product_name' => $this->faker->name,
            'product_desc' => $this->faker->text,
            'qty' => rand(1,100),
            'price' => rand(1,1000),
        ];
    }
}
