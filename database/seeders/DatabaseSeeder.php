<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesAndPermissionsTableSeeder::class);
        $this->call([UsersTableSeeder::class]);
        $this->call(PageSeeder::class);
        $this->call(CodeSeeder::class);
        $this->call(ClientSeeder::class);
      //  $this->call(CategorySeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(StepSeeder::class);
        $this->call(FieldSeeder::class);
        $this->call([
            CountriesTableSeeder::class,
            StatesTableSeeder::class,
            CitiesTableSeeder::class,
        ]);
    }
}
