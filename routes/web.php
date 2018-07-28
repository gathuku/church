<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/profile', 'HomeController@index')->name('profile');
Route::post('profile/update_avatar','UserController@update_avatar');
Route::post('profile/update','UserController@update');
Route::post('comments/store','CommentController@store');

Route::get('/excell/users','ExcellController@usersexport');
Route::get('/excel/tithes','ExcellController@tithesexport');

Route::resources([
'profile' => 'UserController',
'tithe'  => 'TitheController',
'message' =>'MessageController',
'announ' => 'AnnounController',
'comments' =>'CommentController',


]);


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
