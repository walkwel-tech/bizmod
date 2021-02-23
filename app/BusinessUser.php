<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BusinessUser extends Pivot
{
    use HasFactory;


    public static function getRandomAccessRoleValue ()
    {
        return static::getAvailableAccessRolesValues()->random();
    }

    public static function getAvailableAccessRolesValues ()
    {
        return static::getAvailableAccessRoles()->keys();
    }

    public static function getAvailableAccessRoles ()
    {
        $values = [
            'owner' => 'Owner',
            'employee' => 'Employee',
            'manager' => 'Manager',
        ];

        return collect($values);
    }
    public static function getDefaultAccessRole () : string
    {
        return 'employee';
    }

}
