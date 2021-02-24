<?php

namespace Database\Seeders;

use \App\Business;
use \App\User;
use \App\BusinessUser;
use App\Code;
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
        $businesses = Business::with('templates')->get();

        $businesses->each(function ($business) {
            $business->templates->each (function ($template) {
                $template->codes()->saveMany(Code::factory()->times(5)->make([
                    'business_id' => $template->business_id
                ]));
            });
        });
    }
}
