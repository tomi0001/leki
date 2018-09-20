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

//Route::get("/welcome","Controller_strona@wyszukaj2");
Route::get('/','Controller@glowna');
Route::get('glowna/{rok?}/{miesiac?}/{dzien?}/{akcja?}','Controller@glowna');
Route::get('pokaz_opis/{id?}','Controller_ajax@pokaz_opis');
Route::get('zaloguj','Controller@zaloguj');
Route::post('logowanie','Controller@logowanie');
Route::get('dodaj_wpis','Controller_ajax@dodaj_wpis');
Route::get('dodaj_opis','Controller_ajax@dodaj_opis');
Route::get('wyszukaj','Controller_szukaj@wyszukaj');
Route::get('wyszukaj2','Controller_szukaj@wyszukaj2');
Route::get("oblicz_srednia/{id?}","Controller_szukaj@oblicz_srednia");
//Route::get('linux','Controller@f');

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
