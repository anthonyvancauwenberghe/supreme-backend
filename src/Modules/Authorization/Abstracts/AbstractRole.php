<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 09.03.19
 * Time: 21:20.
 */

namespace Modules\Authorization\Abstracts;

use Foundation\Exceptions\Exception;

abstract class AbstractRole
{
    protected $role;

    protected $permissions;

    private final function __construct()
    {
    }

    final public static function getRoleName(): string
    {
        $role = static::singleton()->role;

        if (!isset($role)) {
            throw new Exception('Role name not set for ' . get_short_class_name(static::class));
        }

        return $role;
    }

    final public static function getPermissions(): array
    {
        if (method_exists(static::class, "permissions")) {
            $permissions = static::singleton()->permissions();
        } else {
            $permissions = static::singleton()->permissions;
        }

        if (!isset($permissions)) {
            throw new Exception('Permissions not set for role ' . get_short_class_name(static::class));
        }

        return $permissions;
    }

    public static function singleton()
    {
        return new static;
    }
}
