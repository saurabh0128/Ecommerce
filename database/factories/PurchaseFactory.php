<?php

namespace Database\Factories;

use App\Models\Purchase;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Coupone;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Carbon\carbon;

class PurchaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Purchase::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = User::all()->pluck('id')->toArray(); 
        $useraddress_id = UserAddress::all()->pluck('id')->toArray();
        $coupone_id = Coupone::all()->pluck('id')->toArray();
        $payment_mode = ["COD","ONLINE"];
        return [
            'customer_name' => $this->faker->name,
            'user_id' => Arr::random($user_id),
            'user_address_id' => Arr::random($useraddress_id),
            'billing_address_id' => Arr::random($useraddress_id),
            'coupon_id' => Arr::random($coupone_id),
            'shipping_amt' => rand(1,1000),
            'total_amt' => rand(1,1000),
            'is_payed' => rand(0,1),
            'payment_mode' => Arr::random($payment_mode),
            'transaction_no' => $this->faker->numerify('##############'),
            'purchase_date' => Carbon::parse(now())->format(env('APP_DATE_FORMAT')),
            'delivery_date' => Carbon::parse(now())->format(env('APP_DATE_FORMAT')),
            'delivery_status' => $this->faker->text,
            'purchase_status' => $this->faker->text
        ];
    }
}
