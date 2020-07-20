<?php

use Illuminate\Support\Facades\Route;

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
    return view('main');
});

Auth::routes();

Route::get('/main', 'HomeController@index')->name('home');
Route::middleware('auth')->group(function (){
    //kategorije i podkategorije
    Route::get('/kategorije','KategorijaController@index')->name('indexKategorija');
    Route::post('/kategorije/dodajKategoriju','KategorijaController@store')->name('storeKategorija');
    Route::get('/kategorije/{kategorija}/edit','KategorijaController@edit')->name('editKategorija');
    Route::patch('/kategorije/{kategorija}','KategorijaController@update')->name('updateKategorija');
    Route::delete('/kategorije/{kategorija}','KategorijaController@destroy')->name('destroyKategorija');
    Route::get('/kategorije/{kategorija}/konkretne','PodkategorijaController@index')->name('indexPodkategorija');
    Route::post('/kategorije/{kategorija}/konkretne/dodajPodkategoriju','PodkategorijaController@store')->name('storePodkategorija');
    Route::get('/kategorije/konkretne/{podkategorija}','PodkategorijaController@edit')->name('editPodkategorija');
    Route::patch('/kategorije/konkretne/{podkategorija}','PodkategorijaController@update')->name('updatePodkategorija');
    Route::delete('/kategorije/konkretne/{podkategorija}','PodkategorijaController@destroy')->name('destroyPodkategorija');

    //merne jedinice
    Route::get('/jedinice','JedinicamereController@index')->name('indexJedinicamere');
    Route::post('/jedinice/dodajJedinicu','JedinicamereController@store')->name('storeJedinicamere');
    Route::get('/jedinice/{jedinica}/edit','JedinicamereController@edit')->name('editJedinicamere');
    Route::patch('/jedinice/{jedinica}','JedinicamereController@update')->name('updateJedinicamere');
    Route::delete('/jedinice/{jedinica}','JedinicamereController@destroy')->name('destroyJedinicamere');

    //komitenti
    Route::get('/komitenti','KomitentController@index')->name('indexKomitent');
    Route::post('/komitenti/dodaj','KomitentController@store')->name('storeKomitent');
    Route::get('/komitenti{komitent}/show','KomitentController@show')->name('showKomitent');
    Route::get('/komitenti/{komitent}/edit','KomitentController@edit')->name('editKomitent');
    Route::patch('/komitenti/{komitent}','KomitentController@update')->name('updateKomitent');
    Route::delete('/komitenti/{komitent}','KomitentController@destroy')->name('destroyKomitent');

});
