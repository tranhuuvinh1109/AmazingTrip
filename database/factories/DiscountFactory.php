<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class DiscountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $models= \App\Models\Discount::class;
    public function definition()
    {
        return [
            'address_id'=>$this->faker->unique()->numberBetween(1,10),
            'time_start'=>$this->faker->date($format = 'Y-m-d', $max = '2010-01-09'),
            'time_finish'=>$this->faker->date($format='Y-m-d',$min='2010-01-09'),
            'discount_rate'=>$this->faker->numberBetween(1,99),
            'discount_quantity'=>$this->faker->numberBetween(1,100),
            'number_registed'=>$this->faker->numberBetween(0,$max='discount_quantity')
        ];
    }
}