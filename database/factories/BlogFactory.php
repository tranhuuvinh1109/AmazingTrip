<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $models= \App\Models\Blog::class;
    public function definition()
    {
        return [
            'id_user'=>$this->faker->numberBetween(1,20),
            'group_id'=>$this->faker->numberBetween(1,10),
            'blog_image'=>null,
            'blog_content'=>$this->faker->text($maxNbChars=200)
        ];
    }
}
