<?php

namespace Database\Seeders;

use \App\Business;
use \App\User;
use \App\BusinessUser;
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

        $business = Business::factory()
            ->times(7)
            ->hasTemplates(3)
            ->hasCodes(5)
            ->create();

        $users = User::all();
        $users->each(function ($user) use ($business) {
            $businessArray = $business->shuffle()->take(3)->mapWithKeys(function ($b) {
                return [$b->id => ['access' => BusinessUser::getRandomAccessRoleValue()]];
            })->toArray();

            $user->business()->sync($businessArray);
        });
    }
}
