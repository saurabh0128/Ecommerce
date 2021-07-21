<?php

namespace Database\Factories;

use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;   

class StateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = State::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   
        $IndianState = array (
         'Andhra Pradesh',
         'Arunachal Pradesh',
         'Assam',
         'Bihar',
         'Chhattisgarh',
         'Goa',
         'Gujarat',
         'Haryana',
         'Himachal Pradesh',
         'Jammu & Kashmir',
         'Jharkhand',
         'Karnataka',
         'Kerala',
         'Madhya Pradesh',
         'Maharashtra',
         'Manipur',
          'Meghalaya',
          'Mizoram',
          'Nagaland',
          'Odisha',
          'Punjab',
          'Rajasthan',
          'Sikkim',
          'Tamil Nadu',
          'Tripura',
          'Uttarakhand',
          'Uttar Pradesh',
          'West Bengal',
          'Andaman & Nicobar',
          'Chandigarh',
          'Dadra and Nagar Haveli',
          'Daman & Diu',
          'Delhi',
          'Lakshadweep', 
          'Puducherry',
        );
        
        return [
            'StateName' => Arr::random($IndianState),
        ];
    }
}
