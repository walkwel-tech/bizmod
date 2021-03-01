<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->setupPermissionsForNature([
            'users',
            'roles',
            'businesses',
            'codes',
            'clients',
            'templates',
            'permissions',
            'locations'
        ], 'backend');

        $this->setupPermissionsForNature([
            'users'
        ], 'frontend', 'user');

        $superUser = Role::findOrCreate('super');

        $backendAccess = Permission::findOrCreate('backend.access');
        $backendAccess->assignRole($superUser);

        $frontendAccess = Permission::findOrCreate('frontend.access');
        $frontendAccess->assignRole($superUser);

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }

    public function setupPermissionsForNature($permissions, $nature = 'backend', $additionalRole = null)
    {
        $role = Role::findOrCreate('super');

        $backendPermissions = Permission::findOrCreate("{$nature}.*");

        if ($additionalRole) {
            $additionalRole = Role::findOrCreate($additionalRole);
            $backendPermissions->assignRole($additionalRole);
        }

        $backendPermissions->assignRole($role);

        $types = [
            'create',
            'read',
            'update',
            'delete'
        ];

        foreach ($permissions as $permissionKey) {
            foreach ($types as $type) {
                Permission::findOrCreate("{$nature}.{$permissionKey}.{$type}");
            }
        }
    }
}
