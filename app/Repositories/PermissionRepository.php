<?php

namespace App\Repositories;

use App\Contracts\Repository\PermissionRepositoryContract;
use App\BusinessUser;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionRepository implements PermissionRepositoryContract {

    public function getBusinessRoles(): Collection
    {
        return BusinessUser::getAvailableAccessRoles();
    }

    public function getDefaultBusinessUserRole () : string
    {
        return BusinessUser::getDefaultAccessRole();
    }

    public function getRoles(): Collection
    {
        $user = auth()->user();
        if ( !method_exists($user, 'hasRole') || $user->hasRole('super')) {
            return Role::all();
        } else {
            return auth()->user()->roles;
        }

    }

    public function getPermissionGroups(): Collection
    {
        if (auth()->user()->hasRole('super')) {
            $permissionsAvailable = Permission::all();
        } else {
            $permissionsAvailable = auth()->user()->getAllPermissions();
        }


        $permissionsData = $permissionsAvailable->map(function (Permission $permission) {
            $permission->key = str_replace(['.', '*'], ['_', 'all'], $permission->name);

            return $permission;
        });

        $permissions = $permissionsData->groupBy(function ($permission) {
            return explode('.', $permission->name)[1];
        });

        return $permissions;
    }
}
