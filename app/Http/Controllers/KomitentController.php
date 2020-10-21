<?php

namespace App\Http\Controllers;

use App\Komitent;
use App\Rules\ziroracun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KomitentController extends Controller
{
    public function index()
    {
        $komitenti=Komitent::all();
        return view('komitenti.komitenti',['komitenti'=>$komitenti]);
    }
    public function show(Komitent $komitent)
    {
        return view('komitenti.showkomitenta',['komitent'=>$komitent]);
    }
    public function create()
    {
        return view('komitenti.komitentform',['edit'=>false,'komitent'=>null]);
    }
    public function store()
    {
        $attributes=\request()->validate([
            'naziv'=>['required','string','max:40','min:1'],
            'adresa'=>['required','string','max:40','min:1'],
            'postbr'=>['numeric','digits:5','nullable'],
            'mesto'=>['alpha','string','nullable'],
            'telefon'=>['numeric','string','nullable'],
            'odglice'=>['alpha','string','nullable'],
            'zr'=>['digits:18','nullable'],
            'matbr'=>['numeric','digits:8','nullable'],
            'vrkomitenta'=>['integer','nullable'],
            'regbr'=>['numeric','nullable'],
            'pib'=>['required','numeric'],
            'napomena'=>['string','nullable'],
            'web'=>['string','nullable'],
            'e-mail'=>['email','nullable'],
            'prenetostanje'=>['numeric','nullable'],
            'popust'=>['integer'],
            'drzava'=>['string','nullable'],
        ]);
        $pdv=\request('pdv') ? true : false;
        $dobavljac=\request('dobavljac') ? true : false;
        $kupac=\request('kupac') ? true : false;
        $inostrani=\request('inostrani') ? true : false;
        Komitent::create([
            'Naziv'=>$attributes['naziv'],
            'Adresa'=>$attributes['adresa'],
            'PostBr'=>$attributes['postbr'],
            'Mesto'=>$attributes['mesto'],
            'Telefon'=>$attributes['telefon'],
            'OdgLice'=>$attributes['odglice'],
            'ZR'=>$attributes['zr'],
            'MatBr'=>$attributes['matbr'],
            'VrKomitenta'=>$attributes['vrkomitenta'],
            'RegBr'=>$attributes['regbr'],
            'PIB'=>$attributes['pib'],
            'Napomena'=>$attributes['napomena'],
            'Web'=>$attributes['web'],
            'E-mail'=>$attributes['e-mail'],
            'PrenetoStanje'=>$attributes['prenetostanje'],
            'Popust'=>$attributes['popust'],
            'PDV'=>$pdv,
            'Dobavljac'=>$dobavljac,
            'Kupac'=>$kupac
        ]);
        if ($inostrani)
        {
            Komitent::where('PIB',$attributes['pib'])->first()->update([
                'Inostrani'=>true,
                'Drzava'=>$attributes['drzava']
            ]);
        }
        return Redirect::route('indexKomitent');
    }
    public function edit(Komitent $komitent)
    {
        return view('komitenti.komitentform',['edit'=>true,'komitent'=>$komitent]);
    }
    public function update(Komitent $komitent)
    {
        $attributes=\request()->validate([
            'naziv'=>['required','string','max:40','min:1'],
            'adresa'=>['required','string','max:40','min:1'],
            'postbr'=>['numeric','digits:5','nullable'],
            'mesto'=>['alpha','string','nullable'],
            'telefon'=>['numeric','string','nullable'],
            'odglice'=>['alpha','string','nullable'],
            'zr'=>['digits:18','nullable'],
            'matbr'=>['numeric','digits:8','nullable'],
            'vrkomitenta'=>['integer'],
            'regbr'=>['numeric','nullable'],
            'pib'=>['required','numeric'],
            'napomena'=>['string','nullable'],
            'web'=>['string','nullable'],
            'e-mail'=>['email','nullable'],
            'prenetostanje'=>['numeric','nullable'],
            'popust'=>['integer'],
            'drzava'=>['string','nullable'],
        ]);
        $pdv=\request('pdv') ? true : false;
        $dobavljac=\request('dobavljac') ? true : false;
        $kupac=\request('kupac') ? true : false;
        $inostrani=\request('inostrani') ? true : false;
        $komitent->update([
            'Naziv'=>$attributes['naziv'],
            'Adresa'=>$attributes['adresa'],
            'PostBr'=>$attributes['postbr'],
            'Mesto'=>$attributes['mesto'],
            'Telefon'=>$attributes['telefon'],
            'OdgLice'=>$attributes['odglice'],
            'ZR'=>$attributes['zr'],
            'MatBr'=>$attributes['matbr'],
            'VrKomitenta'=>$attributes['vrkomitenta'],
            'RegBr'=>$attributes['regbr'],
            'PIB'=>$attributes['pib'],
            'Napomena'=>$attributes['napomena'],
            'Web'=>$attributes['web'],
            'E-mail'=>$attributes['e-mail'],
            'PrenetoStanje'=>$attributes['prenetostanje'],
            'Popust'=>$attributes['popust'],
            'PDV'=>$pdv,
            'Dobavljac'=>$dobavljac,
            'Kupac'=>$kupac
        ]);
        if ($inostrani)
        {
            $komitent->update([
                'Inostrani'=>true,
                'Drzava'=>$attributes['drzava']
            ]);
        }
        else
        {
            $komitent->update([
                'Inostrani'=>false,
                'Drzava'=>'Srbija'
            ]);
        }
        return Redirect::route('indexKomitent');
    }
    public function destroy(Komitent $komitent)
    {
        Komitent::destroy($komitent->Sifra);
        return Redirect::route('indexKomitent');
    }
}
