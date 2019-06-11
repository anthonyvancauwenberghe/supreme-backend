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

use Modules\Lookbook\Permissions\LookbookPermissions;

Route::get('/droplist', function () {
    return response()->json(\Modules\Supreme\Cache\SupremeDropListCache::get() ?? []);
});

Route::get('/lookbook', function () {
    return response()->json(json_decode(Storage::disk('local')->get('lookbooks/springsummer2019.json') ?? json_encode([])));
}); //->middleware(['permission:'.LookbookPermissions::ACCESS_LOOKBOOK]);