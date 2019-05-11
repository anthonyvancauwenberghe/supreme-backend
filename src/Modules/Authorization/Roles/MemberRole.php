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
use Modules\Creditcard\Permissions\CreditcardPermission;
use Modules\Device\Permissions\DevicePermission;
use Modules\Order\Permissions\OrderPermission;
use Modules\Shipping\Permissions\ShippingPermission;
use Modules\Wishlist\Permissions\WishlistPermission;

class MemberRole extends AbstractRole
{
    protected $role = Role::MEMBER;

    protected $permissions = [
        WishlistPermission::INDEX_WISHLIST,
        WishlistPermission::CREATE_WISHLIST,
        WishlistPermission::DELETE_WISHLIST,

        OrderPermission::CREATE_ORDER,

        DevicePermission::SHOW_DEVICE,
        DevicePermission::CREATE_DEVICE,
        DevicePermission::UPDATE_DEVICE
    ];
}
