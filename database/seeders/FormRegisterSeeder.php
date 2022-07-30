<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormRegister; 
class FormRegisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FormRegister::factory()->count(10)->create();
    }
}
