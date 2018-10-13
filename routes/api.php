<?php

use Illuminate\Http\Request;
use App\User;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('{id}/state', function($id){
    $user = User::find($id);
    return $user->machine;
});

Route::get('{id}/temp/{temp}', function($id, $temp){
    $user = User::find($id);
    $user->update([
        'temp' => $temp,
        'last_update' => date('Y-m-d H:i:s')
    ]);

    return $user->temp;
});