<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', 'FoundationController@api');

Route::get('/authorized', 'FoundationController@authorized')->middleware('auth0');

Route::get('/lookbook', function () {
    return response()->json(json_decode(Storage::disk('local')->get('lookbooks/springsummer2019.json')));
});