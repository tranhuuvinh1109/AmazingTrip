<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReactionBlogAddress;
class ReactionBlogAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReactionBlogAddress::factory()->count(20)->create();
    }
}
