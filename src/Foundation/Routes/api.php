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


Route::get('/info', function () {
    if (app()->environment('local'))
        phpinfo();
    else
        throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
});
