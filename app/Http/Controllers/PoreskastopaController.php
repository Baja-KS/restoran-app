<?php

namespace App\Http\Controllers;

use App\PoreskaStopa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PoreskastopaController extends Controller
{
    public function index()
    {
        $poreskestope=PoreskaStopa::all();
        return view('poreskestope.poreskestope',['poreskestope'=>$poreskestope]);
    }

    public function store()
    {
        $attributes=\request()->validate([
            'opis'=>['required','string'],
            'vrednost'=>['required','numeric']
        ]);
        PoreskaStopa::create([
            'Opis'=>$attributes['opis'],
            'Vrednost'=>$attributes['vrednost']
        ]);
        return Redirect::route('indexPoreskastopa');
    }

    public function edit(PoreskaStopa $poreskastopa)
    {
        return view('poreskestope.editporeskestope',['poreskastopa'=>$poreskastopa]);
    }

    public function update(PoreskaStopa $poreskastopa)
    {
        $attributes=\request()->validate([
            'opis'=>['required','string'],
            'vrednost'=>['required','numeric']
        ]);
        $poreskastopa->update([
            'Opis'=>$attributes['opis'],
            'Vrednost'=>$attributes['vrednost']
        ]);
        return Redirect::route('indexPoreskastopa');
    }

    public function destroy(PoreskaStopa $poreskastopa)
    {
        PoreskaStopa::destroy($poreskastopa->Sifra);
        return Redirect::route('indexPoreskastopa');
    }
}
