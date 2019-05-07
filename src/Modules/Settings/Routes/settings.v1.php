<?php

/*
|--------------------------------------------------------------------------
| Settings API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all API routes for the module Settings. These
| routes are automatically loaded by the Larapi framework and assigned to the "api" middleware group.
| Enjoy building your API!
|
*/

use Modules\Authorization\Entities\Permission;
use Modules\Settings\Permissions\SettingsPermission;

Route::get('/', 'SettingsController@index')->middleware(['permission:'.SettingsPermission::INDEX_SETTINGS]);
Route::get('/{id}', 'SettingsController@show')->middleware(['permission:'.SettingsPermission::SHOW_SETTINGS]);
Route::post('/', 'SettingsController@store')->middleware(['permission:'.SettingsPermission::CREATE_SETTINGS]);
Route::patch('/{id}', 'SettingsController@update')->middleware(['permission:'.SettingsPermission::UPDATE_SETTINGS]);
Route::delete('/{id}', 'SettingsController@destroy')->middleware(['permission:'.SettingsPermission::DELETE_SETTINGS]);



