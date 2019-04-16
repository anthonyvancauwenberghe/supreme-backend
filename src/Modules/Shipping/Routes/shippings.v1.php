<?php

/*
|--------------------------------------------------------------------------
| Shipping API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all API routes for the module Shipping. These
| routes are automatically loaded by the Larapi framework and assigned to the "api" middleware group.
| Enjoy building your API!
|
*/

use Modules\Authorization\Entities\Permission;
use Modules\Shipping\Permissions\ShippingPermission;

Route::get('/', 'ShippingController@index')->middleware(['permission:'.ShippingPermission::INDEX_SHIPPING]);
Route::get('/{id}', 'ShippingController@show')->middleware(['permission:'.ShippingPermission::SHOW_SHIPPING]);
Route::post('/', 'ShippingController@store')->middleware(['permission:'.ShippingPermission::CREATE_SHIPPING]);
Route::patch('/{id}', 'ShippingController@update')->middleware(['permission:'.ShippingPermission::UPDATE_SHIPPING]);
Route::delete('/{id}', 'ShippingController@destroy')->middleware(['permission:'.ShippingPermission::DELETE_SHIPPING]);



