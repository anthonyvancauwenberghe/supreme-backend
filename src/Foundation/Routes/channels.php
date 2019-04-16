<?php


/*
|--------------------------------------------------------------------------
| Channel Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Broadcast routes for your application. These
| routes are loaded by the BroadcastServiceProvider.
|
*/

Broadcast::channel('user.{id}', function ($user, $id) {
    return $user->id === (int) $id;
});
