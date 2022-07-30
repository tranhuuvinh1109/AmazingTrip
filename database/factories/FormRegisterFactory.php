<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
class FormRegisterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $models= \App\Models\FormRegister::class;
    public function definition()
    {
        return [
            'discount_id'=>$this->faker->numberBetween(1,10),
            'id_user'=>$this->faker->numberBetween(1,10),
            'quantity_registed'=>$this->faker->numberBetween(1,10)
        ];
    }
}