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

Route::get('/v1/lookbook', function () {
    return response()->json(json_decode(Storage::disk('local')->get('lookbooks/springsummer2019.json')));
});

Route::get('/v1/droplist', function () {
    return response()->json(\Modules\Supreme\Cache\SupremeDropListCache::get());
});


Route::get('/info', function () {
    if (app()->environment('local'))
        phpinfo();
    else
        throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
});
