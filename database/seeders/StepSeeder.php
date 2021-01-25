<?php

namespace Database\Seeders;

use App\Service;
use App\Step;
use Illuminate\Database\Seeder;

class StepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = Service::inRandomOrder()->take(10)->get();
        $services->each(function (Service $service) {
            $service->steps()->saveMany(Step::factory()->count(5)->make());
        });

    }
}
