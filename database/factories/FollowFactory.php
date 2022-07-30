<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
class FollowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $models= \App\Models\Follow::class;
    public function definition()
    {
        return [
            'follower'=>$this->faker->numberBetween(1,10),
            'being_follower'=>$this->faker->numberBetween(1,10)
        ];
    }
}
