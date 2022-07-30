<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Follow;
class FollowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Follow::factory()->count(10)->create();
    }
}
