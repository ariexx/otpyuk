<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::fallback(function () {
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact admin.',
        'status' => '404',
    ], 404);
});


Route::prefix('v1')->group(function () {
    Route::get('user/{apikey}', 'API\UserController@show');

    //service
    Route::get('service', 'API\ServiceController@getAll');

    //new order
    Route::post('order', 'API\OrderController@store');

    //check order
    Route::get('order', 'API\OrderController@check');

    //update order
    Route::put('order', 'API\OrderController@update');
});
