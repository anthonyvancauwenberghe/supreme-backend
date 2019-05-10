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

    protected $permissions = [
        WishlistPermission::INDEX_WISHLIST,
        WishlistPermission::SHOW_WISHLIST,
        WishlistPermission::CREATE_WISHLIST,
        WishlistPermission::UPDATE_WISHLIST,
        WishlistPermission::DELETE_WISHLIST,

        LookbookPermissions::ACCESS_LOOKBOOK,

        SettingsPermission::UPDATE_SETTINGS,
        SettingsPermission::EDIT_CHECKOUT_DELAY
    ];
}
