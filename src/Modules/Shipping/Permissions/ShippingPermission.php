<?php

namespace Modules\Shipping\Permissions;

interface ShippingPermission
{
    const INDEX_SHIPPING = 'shipping.index';
    const SHOW_SHIPPING = 'shipping.show';
    const UPDATE_SHIPPING = 'shipping.update';
    const CREATE_SHIPPING = 'shipping.create';
    const DELETE_SHIPPING = 'shipping.delete';
}
