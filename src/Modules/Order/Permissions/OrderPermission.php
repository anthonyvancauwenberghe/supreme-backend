<?php

namespace Modules\Order\Permissions;

interface OrderPermission
{
    const INDEX_ORDER = 'order.index';
    const SHOW_ORDER = 'order.show';
    const UPDATE_ORDER = 'order.update';
    const CREATE_ORDER = 'order.create';
    const DELETE_ORDER = 'order.delete';
}
