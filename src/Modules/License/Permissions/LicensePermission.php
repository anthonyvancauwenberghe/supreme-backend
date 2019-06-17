<?php

namespace Modules\License\Permissions;

interface LicensePermission
{
    const INDEX_LICENSE = 'license.index';
    const SHOW_LICENSE = 'license.show';
    const TRANSFER_LICENSE = 'license.update';
    const CREATE_LICENSE = 'license.create';
    const DELETE_LICENSE = 'license.delete';
}
