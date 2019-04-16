<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 09.03.19
 * Time: 21:47.
 */

namespace Modules\Authorization\Managers;

use Foundation\Core\Larapi;

class PermissionManager
{
    public static function getAllPermissions(): array
    {
        return once(function () {
            $permissionClasses = [];
            foreach (Larapi::getModules() as $module) {
                $permissionClasses = array_merge($permissionClasses, $module->getPermissions()->getClasses());
            }
            $permissions = [];
            foreach ($permissionClasses as $permissionClass) {
                $permissions = array_merge($permissions, get_class_constants($permissionClass));
            }
            return $permissions;
        });
    }
}
