<?php

namespace Database\Factories;

use App\Models\SellerCategory;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class SellerCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SellerCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = User::all()->pluck('id')->toArray();
        $category_id = Category::all()->pluck('id')->toArray();
        return [
            'user_id' => Arr::random($user_id),
            'category_id' => Arr::random($category_id)
        ];
    }
}
