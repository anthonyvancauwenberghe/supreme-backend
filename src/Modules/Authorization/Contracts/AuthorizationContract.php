<?php
/**
 * Created by PhpStorm.
 * User: anthony
 * Date: 22-10-18
 * Time: 14:18.
 */

namespace Modules\Authorization\Contracts;

use Modules\Authorization\Entities\Role;

interface AuthorizationContract
{
    public function createRole(string $role, array $permissions): Role;

    public function createPermissions(array $permissions): void;

    public function clearPermissionCache() :void;
}
