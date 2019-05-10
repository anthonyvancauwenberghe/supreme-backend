<?php

/*
|--------------------------------------------------------------------------
| Lookbook API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all API routes for the module ookbook. These
| routes are automatically loaded by the Larapi framework and assigned to the "api" middleware group.
| Enjoy building your API!
|
*/

use Modules\Lookbook\Permissions\LookbookPermissions;

Route::get('/', function () {
   return Storage::disk('local')->get('lookbooks/springsummer2019.json');
})->middleware(['permission:'.LookbookPermissions::ACCESS_LOOKBOOK]);



