<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $cate = Category::all()->pluck('id')->toArray();
        $user = User::all()->pluck('id')->toArray();
        return [
            'product_name' => $this->faker->name,
            'product_desc' => $this->faker->text,
            'product_img' => Str::slug($this->faker->name),
            'current_price' => $this->faker->numerify('####'),
            'special_price' => $this->faker->numerify('####'),
            'category_id' => Arr::random($cate),
            'user_id' => Arr::random($user),
            'is_display' => rand(0,1),
            'is_avilable' => rand(0,1),
            'stock' => rand(1,1000),
            'product_sort_desc' => $this->faker->text,
        ];
    }
}
