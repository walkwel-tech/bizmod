<?php
namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrCreate(
            [
                'email' => 'admin@example.com',
            ],
            [
                'first_name' => 'Admin',
                'last_name' => 'Account',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        if ($role = Role::findByName('super')) {
            $user->assignRole('super');
        }
        $user = User::create(
            [
                'email' => 'user@example.com',            
                'first_name' => 'user',
                'last_name' => 'user',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        if ($role = Role::findByName('user')) {
            $user->assignRole('user');
        }
    }
}
