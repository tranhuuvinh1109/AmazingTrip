<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Travel;
use App\Models\Address;
use App\Models\BlogAddress;
use App\Models\Group;
use App\Models\FormRegister;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(UserSeeder::class);
        $this->call(AddressSeeder::class);
        $this->call(BlogAddressSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(FormRegisterSeeder::class);
    }
}
