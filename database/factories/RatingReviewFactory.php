<?php

namespace Database\Factories;

use App\Models\RatingReview;
use App\Models\Purchase;
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
        $purchase_id = Purchase::all()->pluck('id')->toArray(); 
        return [
            'purchase_id' => Arr::random($purchase_id),
            'rating' => rand(0,5),
            'review' => $this->faker->text,
            'is_display' => rand(0,1),
        ];
    }
}
