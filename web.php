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

Route::get('/', 'Controller@rejestracja');


Route::get('rejestracja',"Controller@rejestracja");
Route::post('zarejestruj',"Controller@zarejestruj");

Route::get('rejestracja2',"Controller2@rejestracja");
Route::get('blad_rejestracji',"Controller@blad_rejestracji");
Route::get('rejestracja_sukces','Controller@rejestracja_sukces');
Route::get('zaloguj','Controller@zaloguj');
Route::post('logowanie','Controller@logowanie');
Route::get('blad','Controller@blad');
Route::get('wyloguj','Controller@wyloguj');
Route::get('glowna/{rok?}/{miesiac?}/{dzien?}/{akcja?}','Controller_strona@glowna');
Route::get('/ajax/dodaj_nastroj','Controller_dodawanie@dodaj_wpis2');
Route::get('/ajax/pokaz_leki','Controller_ajax@pokaz_leki');
Route::get('/ajax/pokaz_opis','Controller_ajax@pokaz_opis');
Route::get('/ajax/usun_lek','Controller_ajax@usun_lek');
Route::get('/ajax/dodaj_lek','Controller_ajax@dodaj_lek');
Route::get('/ajax/edytuj_opis','Controller_ajax@edytuj_opis');
Route::get('/ajax/dodaj_opis','Controller_ajax@dodaj_opis');
Route::get('/ajax/usun_nastroj','Controller_ajax@usun_nastroj');
Route::get('wyszukaj','Controller_szukaj@szukaj');

Route::get('wyszukaj2/{strona?}','Controller_szukaj@szukaj2');
Route::post('dodaj_wpis','Controller_dodawanie@dodaj_wpis');
Route::post('dodaj_sen','Controller_dodawanie2@dodaj_sen');
Route::get('aut/{provider}', 'AuthController@redirectToProvider');
Route::get('aut/{provider}/callback', 'AuthController@handleProviderCallback');




