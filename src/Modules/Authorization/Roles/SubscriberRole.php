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
use Modules\Lookbook\Permissions\LookbookPermissions;
use Modules\Settings\Permissions\SettingsPermission;
use Modules\Wishlist\Permissions\WishlistPermission;

class SubscriberRole extends AbstractRole
{
    protected $role = Role::SUBSCRIBER;

    public function permissions()
    {
        $permissions = MemberRole::getPermissions();
        $additionalPermissions = [];

        return array_merge($permissions, $additionalPermissions);
    }
}
