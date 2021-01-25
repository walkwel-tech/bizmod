<?php

namespace Database\Seeders;

use App\Step;
use App\Field;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $steps = Step::inRandomOrder()->take(10)->get();
        $steps->each(function (Step $step) {
            $step->fields()->saveMany(Field::factory()->count(5)->make());
        });
    }
}
