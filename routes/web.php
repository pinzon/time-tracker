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
    return view('welcome');
});

Route::get('/task', 'TaskController@get' );
Route::post('/task', 'TaskController@new' );
Route::put('/task', 'TaskController@edit' );
Route::put('/task/play', 'TaskController@playButton' );
Route::delete('/task', 'TaskController@delete' );
