<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 09.03.19
 * Time: 21:19.
 */

namespace Modules\Authorization\Roles;

use Modules\Authorization\Abstracts\AbstractRole;
use Modules\Authorization\Entities\Role;
use Modules\Authorization\Managers\PermissionManager;

class AdminRole extends AbstractRole
{
    protected $role = Role::ADMIN;

    public function permissions()
    {
        return PermissionManager::getAllPermissions();
    }
}
