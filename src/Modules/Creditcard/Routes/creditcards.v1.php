<?php

/*
|--------------------------------------------------------------------------
| Creditcard API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all API routes for the module Creditcard. These
| routes are automatically loaded by the Larapi framework and assigned to the "api" middleware group.
| Enjoy building your API!
|
*/

use Modules\Authorization\Entities\Permission;
use Modules\Creditcard\Permissions\CreditcardPermission;

Route::get('/', 'CreditcardController@index')->middleware(['permission:'.CreditcardPermission::INDEX_CREDITCARD]);
Route::get('/{id}', 'CreditcardController@show')->middleware(['permission:'.CreditcardPermission::SHOW_CREDITCARD]);
Route::post('/', 'CreditcardController@store')->middleware(['permission:'.CreditcardPermission::CREATE_CREDITCARD]);
Route::patch('/{id}', 'CreditcardController@update')->middleware(['permission:'.CreditcardPermission::UPDATE_CREDITCARD]);
Route::delete('/{id}', 'CreditcardController@destroy')->middleware(['permission:'.CreditcardPermission::DELETE_CREDITCARD]);



