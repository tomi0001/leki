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
Route::get('usun_wpis/{id?}','Controller_ajax@usun_wpis');
Route::get('zaloguj','Controller@zaloguj');
Route::get('wyloguj','Controller@wyloguj');
Route::get('rejestracja','Controller@zarejestruj');
Route::post('zarejestruj','Controller@rejestracja');
Route::post('logowanie','Controller@logowanie');
Route::get('dodaj_wpis','Controller_ajax@dodaj_wpis');
Route::get('dodaj_opis','Controller_ajax@dodaj_opis');
Route::get('wyszukaj','Controller_szukaj@wyszukaj');
Route::get('wyszukaj2','Controller_szukaj@wyszukaj2');
Route::get('nowy','Controller@dodaj_nowy');
Route::get("oblicz_srednia/{id?}","Controller_szukaj@oblicz_srednia");
Route::get("nowa_grupa","Controller@nowa_grupa");
Route::get("nowa_substancja","Controller@nowa_substancja");
Route::get("dodaj_produkt","Controller@nowy_produkt");
Route::get("edytuj_produkt","Controller@edytuj_produkt");
Route::get("modyfikuj_sub","Controller_ajax@modyfikuj_sub");
Route::get("edytuj_sub","Controller@edytuj_sub");
Route::get("edytuj_pro","Controller@edytuj_pro");
Route::get("modyfikuj_pro","Controller_ajax@modyfikuj_pro");
Route::get("edytuj_grupe","Controller_ajax@modyfikuj_grupe");
Route::get("edytuj_grupe2","Controller@modyfikuj_grupe2");
Route::get("przelicz","Controller_ajax@przelicz");
//Route::get('linux','Controller@f');

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
