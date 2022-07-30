<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
class ReactionBlogAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $models=\App\Models\ReactionBlogAddress::class;
    public function definition()
    {
        return [
            'blog_address_id'=>$this->faker->numberBetween(1,10),
            'id_user'=>$this->faker->numberBetween(1,20),
            'reaction'=>$this->faker->randomElemment([1,2]),
            'reaction_blog_status'=>$this->randomElement([0,1])
        ];
    }
}
