<?php

namespace Modules\Settings\Permissions;

interface SettingsPermission
{
    const INDEX_SETTINGS = 'settings.index';
    const SHOW_SETTINGS = 'settings.show';
    const UPDATE_SETTINGS = 'settings.update';
    const CREATE_SETTINGS = 'settings.create';
    const DELETE_SETTINGS = 'settings.delete';
}
