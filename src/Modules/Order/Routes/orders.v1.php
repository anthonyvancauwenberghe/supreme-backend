<?php

/*
|--------------------------------------------------------------------------
| Order API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all API routes for the module Order. These
| routes are automatically loaded by the Larapi framework and assigned to the "api" middleware group.
| Enjoy building your API!
|
*/

use Modules\Authorization\Entities\Permission;
use Modules\Order\Permissions\OrderPermission;

Route::get('/', 'OrderController@index')->middleware(['permission:'.OrderPermission::INDEX_ORDER]);
Route::get('/{id}', 'OrderController@show')->middleware(['permission:'.OrderPermission::SHOW_ORDER]);
Route::post('/', 'OrderController@store')->middleware(['permission:'.OrderPermission::CREATE_ORDER]);
Route::patch('/{id}', 'OrderController@update')->middleware(['permission:'.OrderPermission::UPDATE_ORDER]);
Route::delete('/{id}', 'OrderController@destroy')->middleware(['permission:'.OrderPermission::DELETE_ORDER]);



