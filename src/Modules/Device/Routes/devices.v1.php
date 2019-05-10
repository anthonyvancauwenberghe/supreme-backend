<?php

/*
|--------------------------------------------------------------------------
| Device API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all API routes for the module Device. These
| routes are automatically loaded by the Larapi framework and assigned to the "api" middleware group.
| Enjoy building your API!
|
*/

use Modules\Authorization\Entities\Permission;
use Modules\Device\Permissions\DevicePermission;

Route::get('/', 'DeviceController@index')->middleware(['permission:'.DevicePermission::INDEX_DEVICE]);
Route::get('/{id}', 'DeviceController@show')->middleware(['permission:'.DevicePermission::SHOW_DEVICE]);
Route::post('/', 'DeviceController@store')->middleware(['permission:'.DevicePermission::CREATE_DEVICE]);
Route::patch('/{id}', 'DeviceController@update')->middleware(['permission:'.DevicePermission::UPDATE_DEVICE]);
Route::delete('/{id}', 'DeviceController@destroy')->middleware(['permission:'.DevicePermission::DELETE_DEVICE]);



