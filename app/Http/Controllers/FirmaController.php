<?php

namespace App\Http\Controllers;

use App\Firma;
use App\Stampac;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FirmaController extends Controller
{
    public function index()
    {
        return view('firme.createfirme',['firme'=>Firma::all(),'stampaci'=>Stampac::all()]);
    }

    public function show(Firma $firma)
    {
        return view('firme.showfirme',['firme'=>Firma::all(),'firma'=>$firma]);
    }

    public function store()
    {
        $attributes=\request()->validate([
            'naziv'=>['required','string','max:40','min:1'],
            'adresa'=>['required','string','max:40','min:1'],
            'pib'=>['required','numeric'],
            'maticnibroj'=>['required','numeric','digits:8'],
            'tekuciracun'=>['required','numeric','digits:18'],
            'banka'=>['required','string','max:40','min:1'],
            'telefon'=>['required','numeric','string'],
            'faks'=>['numeric','string','nullable'],
            'poslovnagodina'=>['nullable','date_format:Y'],
            'objekat'=>['required','string'],
            'stampacid'=>['required','numeric'],
        ]);
        $pdv=\request('pdv') ? true : false ;
        Firma::create([
            'Naziv'=>$attributes['naziv'],
            'Adresa'=>$attributes['adresa'],
            'PIB'=>$attributes['pib'],
            'MaticniBroj'=>$attributes['maticnibroj'],
            'TekuciRacun'=>$attributes['tekuciracun'],
            'Banka'=>$attributes['banka'],
            'Telefon'=>$attributes['telefon'],
            'Faks'=>$attributes['faks'],
            'PoslovnaGodina'=>$attributes['poslovnagodina'] ?? date("Y"),
            'Objekat'=>$attributes['objekat'],
            'StampacID'=>$attributes['stampacid'],
            'PDV'=>$pdv
        ]);
        return Redirect::route('indexFirma');
    }

    public function edit(Firma $firma)
    {
        return view('firme.editfirme',['firme'=>Firma::all(),'firma'=>$firma,'stampaci'=>Stampac::all()]);
    }

    public function update(Firma $firma)
    {
        $attributes=\request()->validate([
            'naziv'=>['required','string','max:40','min:1'],
            'adresa'=>['required','string','max:40','min:1'],
            'pib'=>['required','numeric'],
            'maticnibroj'=>['required','numeric','digits:8'],
            'tekuciracun'=>['required','numeric','digits:18'],
            'banka'=>['required','string','max:40','min:1'],
            'telefon'=>['required','numeric','string'],
            'faks'=>['numeric','string','nullable'],
            'poslovnagodina'=>['nullable','date_format:Y'],
            'objekat'=>['required','string'],
            'stampacid'=>['required','numeric'],
        ]);
        $pdv=\request('pdv') ? true : false ;
        $firma->update([
            'Naziv'=>$attributes['naziv'],
            'Adresa'=>$attributes['adresa'],
            'PIB'=>$attributes['pib'],
            'MaticniBroj'=>$attributes['maticnibroj'],
            'TekuciRacun'=>$attributes['tekuciracun'],
            'Banka'=>$attributes['banka'],
            'Telefon'=>$attributes['telefon'],
            'Faks'=>$attributes['faks'],
            'PoslovnaGodina'=>$attributes['poslovnagodina'] ?? date("Y"),
            'Objekat'=>$attributes['objekat'],
            'StampacID'=>$attributes['stampacid'],
            'PDV'=>$pdv
        ]);
        return Redirect::route('indexFirma');
    }

    public function destroy(Firma $firma)
    {
        Firma::destroy($firma->FirmaID);
        return Redirect::route('indexFirma');
    }
}
