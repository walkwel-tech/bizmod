<?php

namespace Database\Seeders;

use \App\Service;
use \App\Category;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //option  2: Larvel 8

        Category::factory()
            ->times(7)
            ->hasServices(5)
            ->create();
    }
}
