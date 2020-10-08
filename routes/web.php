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



Auth::routes();


Route::middleware('auth')->group(function (){

    Route::get('/main', 'HomeController@index')->name('home');
    Route::get('/', function () {
        return view('main');
    });
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


    //poreske stope
    Route::get('/poreskestope','PoreskastopaController@index')->name('indexPoreskastopa');
    Route::post('/poreskestope/dodajPoreskustopu','PoreskastopaController@store')->name('storePoreskastopa');
    Route::get('/poreskestope/{poreskastopa}/edit','PoreskastopaController@edit')->name('editPoreskastopa');
    Route::patch('/poreskestope/{poreskastopa}','PoreskastopaController@update')->name('updatePoreskastopa');
    Route::delete('/poreskestope/{poreskastopa}','PoreskastopaController@destroy')->name('destroyPoreskastopa');

    //artikli
    Route::get('/artikli','ArtikalController@index')->name('indexArtikal');
    Route::get('/artikli/{artikal:PLUKod}/show','ArtikalController@show')->name('showArtikal');
    Route::get('/artikli/dodaj','ArtikalController@create')->name('createArtikal');
    Route::post('/artikli/dodaj','ArtikalController@store')->name('storeArtikal');
    Route::get('/artikli/{artikal:PLUKod}/edit','ArtikalController@edit')->name('editArtikal');
    Route::patch('/artikli/{artikal:PLUKod}','ArtikalController@update')->name('updateArtikal');
//    Route::delete('/artikli/{artikal:PLUKod}','ArtikalController@destroy')->name('destroyArtikal'); Izbaceno,artikli se ne brisu
    Route::get('/artikli/grupe','GrupaAjaxController@show')->name('showGrupa');

    //vrste dokumenta
    Route::get('/vrstedokumenta','VrstadokumentaController@index')->name('indexVrstadokumenta');
    Route::get('/vrstedokumenta/dodaj','VrstadokumentaController@create')->name('createVrstadokumenta');
    Route::post('/vrstedokumenta/dodaj','VrstadokumentaController@store')->name('storeVrstadokumenta');
    Route::get('/vrstedokumenta/{vrstadokumenta}/edit','VrstadokumentaController@edit')->name('editVrstadokumenta');
    Route::patch('/vrstedokumenta/{vrstadokumenta}','VrstadokumentaController@update')->name('updateVrstadokumenta');
    Route::delete('/vrstedokumenta/{vrstadokumenta}','VrstadokumentaController@destroy')->name('destroyVrstadokumenta');

    //vrste placanja
    Route::get('/vrsteplacanja','VrstaplacanjaController@index')->name('indexVrstaplacanja');
//    Route::get('/vrsteplacanja/dodaj','VrstaplacanjaController@create')->name('createVrstaPlacanja');
    Route::post('/vrsteplacanja/dodaj','VrstaplacanjaController@store')->name('storeVrstaplacanja');
    Route::get('/vrsteplacanja/{vrstaplacanja}/edit','VrstaplacanjaController@edit')->name('editVrstaplacanja');
    Route::patch('/vrsteplacanja/{vrstaplacanja}','VrstaplacanjaController@update')->name('updateVrstaplacanja');
    Route::delete('/vrsteplacanja/{vrstaplacanja}','VrstaplacanjaController@destroy')->name('destroyVrstaplacanja');

    //stampaci
    Route::get('/stampaci','StampacController@index')->name('indexStampac');
    Route::post('/stampaci/dodaj','StampacController@store')->name('storeStampac');
    Route::get('/stampaci/{stampac}/edit','StampacController@edit')->name('editStampac');
    Route::patch('/stampaci/{stampac}','StampacController@update')->name('updateStampac');
    Route::delete('/stampaci/{stampac}','StampacController@destroy')->name('destroyStampac');

    //Organizacione jedinice
    Route::get('/orgjed','OrganizacionajedinicaController@index')->name('indexOrganizacionajedinica');
    Route::get('/orgjed/{organizacionajedinica}/show','OrganizacionajedinicaController@show')->name('showOrganizacionajedinica');
    Route::post('/orgjed/dodaj','OrganizacionajedinicaController@store')->name('storeOrganizacionajedinica');
    Route::get('/orgjed/{organizacionajedinica}/edit','OrganizacionajedinicaController@edit')->name('editOrganizacionajedinica');
    Route::patch('/orgjed/{organizacionajedinica}','OrganizacionajedinicaController@update')->name('updateOrganizacionajedinica');
    Route::delete('/orgjed/{organizacionajedinica}','OrganizacionajedinicaController@destroy')->name('destroyOrganizacionajedinica');

    //Firme
//    Route::get('/firme','FirmaController@index')->name('indexFirma');
//    Route::get('/firme/{firma}/show','FirmaController@show')->name('showFirma');
//    Route::post('/firme/dodaj','FirmaController@store')->name('storeFirma');
//    Route::get('/firme/{firma}/edit','FirmaController@edit')->name('editFirma');
//    Route::patch('/firme/{firma}','FirmaController@update')->name('updateFirma');
//    Route::delete('/firme/{firma}','FirmaController@destroy')->name('destroyFirma');

    Route::middleware('can:admin')->group(function (){
        Route::get('/firme','FirmaController@index')->name('indexFirma');
        Route::get('/firme/{firma}/show','FirmaController@show')->name('showFirma');
        Route::post('/firme/dodaj','FirmaController@store')->name('storeFirma');
        Route::get('/firme/{firma}/edit','FirmaController@edit')->name('editFirma');
        Route::patch('/firme/{firma}','FirmaController@update')->name('updateFirma');
        Route::delete('/firme/{firma}','FirmaController@destroy')->name('destroyFirma');
    });

    //kasa
    Route::get('/kasa/{sto}/{greska?}','KasaController@create')->name('createKasa');//sto bez prethodne porduzbine
    Route::post('/kasa/{sto}/noviracun','KasaController@store')->name('storeKasa');//BACKEND pamti porudzbinu i stampa naloge kuhinji i sanku ili zatvara racun
    Route::get('/kasaedit/{sto}/{greska?}','KasaController@edit')->name('editKasa');//sto sa prethodnom porudzbinom
//    Route::get('/kasanaplata/{sto}','KasaController@naplata')->name('naplataKasa');//otvara formu za naplatu,Izbaceno
    Route::delete('/kasanaplata/{sto}/naplati','KasaController@naplati')->name('naplatiKasa');//BACKEND brise porudzbinu iz baze,stampa racun,i pise isti u dokumenta
    Route::delete('/kasanaplatafirma/{sto}/naplati','KasaController@naplatiZaFirmu')->name('naplatiKasaFirma');

    //prodaja konobara
    Route::get('/prodaja','ProdajaController@index')->name('indexProdajaKonobara');
    Route::get('/prodaja/dnevna','ProdajaController@dnevna')->name('dnevnaProdajaKonobara');
    Route::get('/prodaja/nedeljna','ProdajaController@nedeljna')->name('nedeljnaProdajaKonobara');
    Route::get('/prodaja/mesecna','ProdajaController@mesecna')->name('mesecnaProdajaKonobara');

    Route::middleware('can:admin')->group(function (){
        Route::get('/prodaja/svi','ProdajaController@indexSvi')->name('indexProdajaSvihKonobara');
        Route::get('/prodaja/dnevna/svi','ProdajaController@dnevnaSvi')->name('dnevnaProdajaSvihKonobara');
        Route::get('/prodaja/nedeljna/svi','ProdajaController@nedeljnaSvi')->name('nedeljnaProdajaSvihKonobara');
        Route::get('/prodaja/mesecna/svi','ProdajaController@mesecnaSvi')->name('mesecnaProdajaSvihKonobara');
    });
    Route::get('/prodaja/detalji/{dokument}','ProdajaController@show')->name('detaljiProdaja');

    //administracija
    Route::get('/administracija','AdministracijaController@index')->name('indexAdministracija');
    //komitenti
    Route::get('/administracija/komitenti','KomitentController@index')->name('indexKomitent');
    Route::get('/administracija/komtineti/dodaj','KomitentController@create')->name('createKomitent');
    Route::post('/administracija/komitenti/dodaj','KomitentController@store')->name('storeKomitent');
    Route::get('/administracija/komitenti/{komitent}/show','KomitentController@show')->name('showKomitent');
    Route::get('/administracija/komitenti/{komitent}/edit','KomitentController@edit')->name('editKomitent');
    Route::patch('/administracija/komitenti/{komitent}','KomitentController@update')->name('updateKomitent');
    Route::delete('/administracija/komitenti/{komitent}','KomitentController@destroy')->name('destroyKomitent');

    Route::get('/administracija/prijemnice','PrijemnicaController@index')->name('indexPrijemnica');
//    Route::get('/administracija/prijemnice/table','PrijemnicaController@tableIndex')->name('tablePrijemnica');
    Route::get('/administracija/prijemnice/dodaj','PrijemnicaController@create')->name('createPrijemnica');
    Route::get('/administracija/prijemnice/dodaj/sifPromena','PrijemnicaController@sifraPromena')->name('sifraPromena');
    Route::get('/administracija/prijemnice/dodaj/dobavljacPdv','PrijemnicaController@dobavljacPdv')->name('dobavljacPdv');
    Route::post('/administracija/prijemnice/dodaj','PrijemnicaController@store')->name('storePrijemnica');
    Route::delete('/administracija/prijemnice/brisi/{dokument}','PrijemnicaController@destroy')->name('destroyPrijemnica');
    Route::patch('/administracija/prijemnice/knjizi/{dokument}','PrijemnicaController@proknjizi')->name('proknjiziPrijemnica');
    Route::get('/administracija/prijemnice/izmeni/{dokument}','PrijemnicaController@edit')->name('editPrijemnica');
    Route::patch('/administracija/prijemnice/izmeni/{dokument}/update','PrijemnicaController@update')->name('updatePrijemnica');
    Route::get('/administracija/prijemnice/stampaj/{dokument}','PrijemnicaController@stampa')->name('stampaPrijemnica');

});
