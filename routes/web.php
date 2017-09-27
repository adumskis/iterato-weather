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

Auth::routes();

Route::get('/', 'MainController@home')->name('main.home');
Route::patch('update-token', 'MainController@updateToken')->middleware('guest')->name('main.updateToken');


Route::get('test', function(){
    dd(\App\Facades\Weather::appId('089b372bbf91c747bd842cb082c2263c')->query('utena')->raw());
});