<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Address::class;
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return[
            'id_host'=>$this->faker->numberBetween(1,10),
            'address_name'=>$this->faker->company,
            'address_description'=>$this->faker->text($maxNbChars = 200),
            'address_image'=>('https://wall.vn/wp-content/uploads/2020/03/hinh-anh-vinh-ha-long-4.jpg'),
            'address_map'=>$this->faker->address   
        ];
    }
};
