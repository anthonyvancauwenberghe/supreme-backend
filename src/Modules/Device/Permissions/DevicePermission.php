<?php

namespace Modules\Device\Permissions;

interface DevicePermission
{
    const INDEX_DEVICE = 'device.index';
    const SHOW_DEVICE = 'device.show';
    const UPDATE_DEVICE = 'device.update';
    const CREATE_DEVICE = 'device.create';
    const DELETE_DEVICE = 'device.delete';
}
