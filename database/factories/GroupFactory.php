<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Group;

class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model= \App\Models\Group::class;
    public function definition()
    {
        return [
           "group_name"=>$this->faker->company,
           "group_image"=>null,
           "address_id"=>$this->faker->numberBetween(1,10),
           "group_admin"=>$this->faker->numberBetween(1,20),
           //"group_member"=>$this->faker->numberBetween(1,10),
        ];
    }
}
