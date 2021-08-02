<?php

namespace Database\Factories;

use App\Models\RatingReview;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class RatingReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RatingReview::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // $purchase_id = Purchase::all()->pluck('id')->toArray(); 
        $product_id = Product::all()->pluck('id')->toArray();
        $user_id = User::all()->pluck('id')->toArray();
        return [
            'rating' => rand(0,5),
            'review' => $this->faker->text,
            'is_display' => rand(0,1),
            'product_id' => Arr::random($product_id),
            'user_id' => Arr::random($user_id),

        ];
    }
}
