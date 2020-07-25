<?php

namespace App\Http\Controllers;

use App\VrstaDokumenta;
use App\VrstaPlacanja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class VrstaplacanjaController extends Controller
{
    public function index()
    {
        return view('vrsteplacanja.createvrsteplacanja',['vrsteplacanja'=>VrstaPlacanja::all()]);
    }

    public function store()
    {
        $attributes=\request()->validate([
            'naziv'=>['required','string']
        ]);
        VrstaPlacanja::create([
            'Naziv'=>$attributes['naziv']
        ]);
        return Redirect::route('indexVrstaplacanja');
    }

    public function edit(VrstaPlacanja $vrstaplacanja)
    {
        return view('vrsteplacanja.editvrsteplacanja',['vrstaplacanja'=>$vrstaplacanja,'vrsteplacanja'=>VrstaPlacanja::all()]);
    }

    public function update(VrstaPlacanja $vrstaplacanja)
    {
        $attributes=\request()->validate([
            'naziv'=>['required','string']
        ]);
        $vrstaplacanja->update([
            'Naziv'=>$attributes['naziv']
        ]);
        return Redirect::route('indexVrstaplacanja');
    }

    public function destroy(VrstaPlacanja $vrstaplacanja)
    {
        VrstaPlacanja::destroy($vrstaplacanja->VrstaPlacanja);
        return Redirect::route('indexVrstaplacanja');
    }
}
