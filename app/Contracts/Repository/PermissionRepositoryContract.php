<?php

namespace App\Contracts\Repository;

use Illuminate\Support\Collection;


interface PermissionRepositoryContract {
    public function getPermissionGroups() : Collection;
    public function getRoles() : Collection;

    public function getBusinessRoles() : Collection;
    public function getDefaultBusinessUserRole(): string;
}
