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
        return view('merneJedinice.jedinicaform',['edit'=>false,'jedinica'=>null,'jedinice'=>$jedinice]);
    }
    public function store()
    {
        $attributes=\request()->validate(['naziv'=>['required','alpha','string','max:5','min:1']]);

        Jedinicamere::create(['Naziv'=> $attributes['naziv']]);
        return Redirect::route('indexJedinicamere');
    }
    public function edit(Jedinicamere $jedinica)
    {
        $jedinice=Jedinicamere::all();
        return view('merneJedinice.jedinicaform',['edit'=>true,'jedinica'=>$jedinica,'jedinice'=>$jedinice]);
    }
    public function update(Jedinicamere $jedinica)
    {
        $attributes=\request()->validate(['naziv'=>['required','alpha','string','max:5','min:1']]);
        $jedinica->update(['Naziv'=>$attributes['naziv']]);
        return Redirect::route('indexJedinicamere');
    }
    public function destroy(Jedinicamere $jedinica)
    {
        Jedinicamere::destroy($jedinica->JMID);
        return Redirect::route('indexJedinicamere');
    }
}
