<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Discount;
class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Discount::factory()->count(10)->create();
    }
}