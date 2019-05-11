<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 09.03.19
 * Time: 21:47.
 */

namespace Modules\Authorization\Managers;

use Modules\Authorization\Abstracts\AbstractRole;
use Modules\Authorization\Roles\AdminRole;
use Modules\Authorization\Roles\GuestRole;
use Modules\Authorization\Roles\MemberRole;
use Modules\Authorization\Roles\ScripterRole;
use Modules\Authorization\Roles\SubscriberRole;

class RoleManager
{
    /**
     * @var AbstractRole[]
     */
    const ROLES = [
        MemberRole::class,
        GuestRole::class,
        AdminRole::class,
        SubscriberRole::class
    ];

    public static function member(): MemberRole
    {
        return MemberRole::singleton();
    }

    public static function admin(): AdminRole
    {
        return AdminRole::singleton();
    }

    public static function guest(): GuestRole
    {
        return GuestRole::singleton();
    }

    public static function subscriber(): SubscriberRole
    {
        return SubscriberRole::singleton();
    }
}
