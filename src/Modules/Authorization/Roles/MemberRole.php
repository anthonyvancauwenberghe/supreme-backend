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
use Modules\Shipping\Permissions\ShippingPermission;
use Modules\Wishlist\Permissions\WishlistPermission;

class MemberRole extends AbstractRole
{
    protected $role = Role::MEMBER;

    protected $permissions = [
        ShippingPermission::INDEX_SHIPPING,
        ShippingPermission::SHOW_SHIPPING,
        ShippingPermission::CREATE_SHIPPING,
        ShippingPermission::UPDATE_SHIPPING,
        ShippingPermission::DELETE_SHIPPING,

        CreditcardPermission::INDEX_CREDITCARD,
        CreditcardPermission::SHOW_CREDITCARD,
        CreditcardPermission::CREATE_CREDITCARD,
        CreditcardPermission::UPDATE_CREDITCARD,
        CreditcardPermission::DELETE_CREDITCARD,

        WishlistPermission::INDEX_WISHLIST,
        WishlistPermission::SHOW_WISHLIST,
        WishlistPermission::CREATE_WISHLIST,
        WishlistPermission::UPDATE_WISHLIST,
        WishlistPermission::DELETE_WISHLIST,
    ];
}
