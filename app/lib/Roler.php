<?php

namespace App\Lib;

use Spatie\Permission\Models\Role;

class Roler
{
    public static function newRole($guard_name, $name)
    {
        $response = Role::firstOrCreate(['guard_name' => $guard_name, 'name' => $name]);
        return $response;
    }
    public static function createRole($models, $role)
    {
        $models->assignRole($role);
    }
    public static function UserRole(object $users, array $role)
    {
        if (!$roler = self::newRole($role[0], $role[1]))
            throw new \Exception("role permission error");
        self::createRole($users, $roler);
        return true;
    }
}
