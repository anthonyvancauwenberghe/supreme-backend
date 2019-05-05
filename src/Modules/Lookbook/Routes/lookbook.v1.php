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

Route::get('/', function () {
   return Storage::disk('local')->get('lookbooks/springsummer2019.json');
});



