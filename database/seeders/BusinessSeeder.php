<?php

namespace Database\Seeders;

use \App\Business;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Business::factory()->count(6)->create();
    }
}
