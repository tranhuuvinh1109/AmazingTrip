<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model= \App\Models\User::class;
    public function definition()
    {
        return [
                'username'=>$this->faker->unique()->name ,
                'birthday'=>$this->faker->date($format = 'Y-m-d', $max = 'now'),
                'email'=>$this->faker->unique()->email,
                'phone'=>$this->faker->unique()->phoneNumber,
                'password'=>'1122334455',
                'address'=>$this->faker->address,
                'nickname'=>$this->faker->lastName ,
                'avatar'=>null,
                'role'  =>$this->faker->randomElement([0,1, 2])
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
