<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
class BookmarkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $models= \App\Models\Bookmark::class;
    public function definition()
    {
        return [
              'address_id'=>$this->faker->numberBetween(1,10),
              'id_user'=>$this->faker->numberBetween(1,50),
              'status'=>$this->faker->randomElement([0,1])
        ];
    }
}
