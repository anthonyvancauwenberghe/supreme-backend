<?php
/**
 * Created by PhpStorm.
 * User: anthony
 * Date: 22-10-18
 * Time: 14:18.
 */

namespace Modules\Authorization\Services;

use Modules\Authorization\Contracts\AuthorizationContract;
use Modules\Authorization\Entities\Permission;
use Modules\Authorization\Entities\Role;

class AuthorizationService implements AuthorizationContract
{
    public function createRole(string $role, array $permissions): Role
    {
        $role = Role::create([
            'name'       => $role,
            'guard_name' => 'api',
        ]);
        $role->givePermissionTo($permissions);

        return $role;
    }

    public function createPermissions(array $permissions): void
    {
        foreach ($permissions as $permission) {
            Permission::create([
                'name'       => $permission,
                'guard_name' => 'api',
            ]);
        }
    }

    public function clearPermissionCache() :void
    {
        app()['cache']->forget('spatie.permission.cache');
    }
}
