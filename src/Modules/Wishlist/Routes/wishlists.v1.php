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
Route::get('/{id}', 'WishlistController@show')->middleware(['permission:'.WishlistPermission::SHOW_WISHLIST]);
Route::post('/', 'WishlistController@store')->middleware(['permission:'.WishlistPermission::CREATE_WISHLIST]);
Route::patch('/{id}', 'WishlistController@update')->middleware(['permission:'.WishlistPermission::UPDATE_WISHLIST]);
Route::delete('/{id}', 'WishlistController@destroy')->middleware(['permission:'.WishlistPermission::DELETE_WISHLIST]);



