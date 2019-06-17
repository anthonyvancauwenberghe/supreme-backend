<?php

/*
|--------------------------------------------------------------------------
| License API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all API routes for the module License. These
| routes are automatically loaded by the Larapi framework and assigned to the "api" middleware group.
| Enjoy building your API!
|
*/

use Modules\Authorization\Entities\Permission;
use Modules\License\Permissions\LicensePermission;

Route::get('/', 'LicenseController@index')->middleware(['permission:'.LicensePermission::INDEX_LICENSE]);
Route::post('/{id}/transfer', 'LicenseController@transfer')->middleware(['permission:'.LicensePermission::TRANSFER_LICENSE]);



