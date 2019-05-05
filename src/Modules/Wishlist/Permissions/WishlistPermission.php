<?php

namespace Modules\Wishlist\Permissions;

interface WishlistPermission
{
    const INDEX_WISHLIST = 'wishlist.index';
    const SHOW_WISHLIST = 'wishlist.show';
    const UPDATE_WISHLIST = 'wishlist.update';
    const CREATE_WISHLIST = 'wishlist.create';
    const DELETE_WISHLIST = 'wishlist.delete';
}
