<?php

/*
|--------------------------------------------------------------------------
| Wishlist API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all API routes for the module Wishlist. These
| routes are automatically loaded by the Larapi framework and assigned to the "api" middleware group.
| Enjoy building your API!
|
*/

use Modules\Authorization\Entities\Permission;
use Modules\Wishlist\Permissions\WishlistPermission;

Route::get('/', 'WishlistController@index')->middleware(['permission:'.WishlistPermission::INDEX_WISHLIST]);
Route::post('/', 'WishlistController@store')->middleware(['permission:'.WishlistPermission::CREATE_WISHLIST]);
Route::delete('/{id}', 'WishlistController@destroy')->middleware(['permission:'.WishlistPermission::DELETE_WISHLIST]);
