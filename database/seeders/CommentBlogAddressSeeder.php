<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CommentBlogAddress;
class CommentBlogAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CommentBlogAddress::factory()->count(30)->create();
    }
}
