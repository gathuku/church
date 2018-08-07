<?php

use Illuminate\Http\Request;

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

//Route::post('callback','MpesaController@getDataFromCallback');

Route::post('confirmationurl','MpesaController@getDataFromCallback');

Route::post('validationurl','MpesaController@receiveresponse');
Route::any("stk_push", "MpesaController@stk");
Route::any("c2b_simulate", "MpesaController@simulate_c2b");


