<?php

namespace Database\Factories;

use App\Models\SellerPayment;
use App\Models\User;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class SellerPaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SellerPayment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = User::all()->pluck('id')->toArray();
        $purchase_id = Purchase::all()->pluck('id')->toArray();
        $payment_mode = ["COD","ONLINE"];
        return [
            'user_id' =>  Arr::random($user_id),
            'purchase_id' => Arr::random($purchase_id),
            'payable_amt' => $this->faker->numerify('###'),
            'chargable_amt' => $this->faker->numerify('####'),
            'is_payed' => rand(0,1),
            'payment_mode' => Arr::random($payment_mode),
            'transaction_no' => $this->faker->numerify('##############'),
        ];
    }
}
