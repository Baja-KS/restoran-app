<?php

namespace App\Http\Controllers;

use App\Jedinicamere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class JedinicamereController extends Controller
{
    public function index()
    {
        $jedinice=Jedinicamere::all();
        return view('merneJedinice.jedinicemere',['jedinice'=>$jedinice]);
    }
    public function store()
    {
        $attributes=\request()->validate(['sjm'=>['required','alpha','string','max:5','min:1']]);

        Jedinicamere::create(['Naziv'=> $attributes['sjm']]);
        return Redirect::route('indexJedinicamere');
    }
    public function edit(Jedinicamere $jedinica)
    {
        return view('merneJedinice.editjedinica',['jedinica'=>$jedinica]);
    }
    public function update(Jedinicamere $jedinica)
    {
        $attributes=\request()->validate(['ujm'=>['required','alpha','string','max:5','min:1']]);
        $jedinica->update(['Naziv'=>$attributes['ujm']]);
        return Redirect::route('indexJedinicamere');
    }
    public function destroy(Jedinicamere $jedinica)
    {
        Jedinicamere::destroy($jedinica->JMID);
        return Redirect::route('indexJedinicamere');
    }
}
