<?php

namespace Database\Seeders;

use \App\Business;
use Illuminate\Database\Seeder;

class CodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Business::factory()
            ->times(7)
            ->hasCodes(5)
            ->hasTemplates(3)
            ->create();
    }
}
