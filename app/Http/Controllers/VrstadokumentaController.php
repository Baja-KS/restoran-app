<?php

namespace App\Http\Controllers;

use App\VrstaDokumenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class VrstadokumentaController extends Controller
{
    public function index()
    {
        $vrstedokumenta=VrstaDokumenta::paginate(5);
        return view('dokumenti.vrste.vrstedokumenta',['vrstedokumenta'=>$vrstedokumenta]);
    }

    public function create()
    {
        $ui=['*','I','U','K','N'];
        $mpvp=['MP','VP'];
        return view('dokumenti.vrste.createvrstadokumenta',['ui'=>$ui,'mpvp'=>$mpvp]);
    }

    public function store()
    {
        $attributes=\request()->validate([
            'modul'=>['required','string','size:1'],
            'sifra'=>['required','string','size:3'],
            'opis'=>['required','string'],
        ]);
        $ui=\request('ui');
        $mpvp=\request('mpvp');
        $pdv=\request('pdv') ? true : false;
        $autoknj=\request('autoknj') ? true : false;
        $akkorisnik=\request('akkorisnik') ? true : false;
        VrstaDokumenta::create([
            'Modul'=>$attributes['modul'],
            'Sifra'=>$attributes['sifra'],
            'UI'=>$ui,
            'Opis'=>$attributes['opis'],
            'PDV'=>$pdv,
            'MPVP'=>$mpvp,
            'AutoKnj'=>$autoknj,
            'AKKorisnik'=>$akkorisnik
        ]);
        return Redirect::route('indexVrstadokumenta');
    }

    public function edit(VrstaDokumenta $vrstadokumenta)
    {
        $ui=['*','I','U','K','N'];
        $mpvp=['MP','VP'];
        return view('dokumenti.vrste.editvrstadokumenta',['vrstadokumenta'=>$vrstadokumenta,'ui'=>$ui,'mpvp'=>$mpvp]);
    }

    public function update(VrstaDokumenta $vrstadokumenta)
    {
        $attributes=\request()->validate([
            'modul'=>['required','string','size:1'],
            'sifra'=>['required','string','size:3'],
            'opis'=>['required','string'],
        ]);
        $ui=\request('ui');
        $mpvp=\request('mpvp');
        $pdv=\request('pdv') ? true : false;
        $autoknj=\request('autoknj') ? true : false;
        $akkorisnik=\request('akkorisnik') ? true : false;
        $vrstadokumenta->update([
            'Modul'=>$attributes['modul'],
            'Sifra'=>$attributes['sifra'],
            'UI'=>$ui,
            'Opis'=>$attributes['opis'],
            'PDV'=>$pdv,
            'MPVP'=>$mpvp,
            'AutoKnj'=>$autoknj,
            'AKKorisnik'=>$akkorisnik
        ]);
        return Redirect::route('indexVrstadokumenta');
    }

    public function destroy(VrstaDokumenta $vrstadokumenta)
    {
        VrstaDokumenta::destroy($vrstadokumenta->id);
        return Redirect::route('indexVrstadokumenta');
    }
}
