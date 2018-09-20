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

Route::get('rejestracja',"Controller@rejestracja");
Route::post('zarejestruj',"Controller@zarejestruj");

Route::get('rejestracja2',"Controller2@rejestracja");
Route::get('blad_rejestracji',"Controller@blad_rejestracji");
Route::get('rejestracja_sukces','Controller@rejestracja_sukces');
Route::get('zaloguj','Controller@zaloguj');
Route::post('logowanie','Controller@logowanie');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
