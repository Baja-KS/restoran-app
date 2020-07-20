<?php

namespace App\Http\Controllers;

use App\Kategorija;
//use App\Podkategorija;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class KategorijaController extends Controller
{
    //---------------------------------------------------------------------------------------
    public function index()
    {
        $kategorije=Kategorija::all();
        return view('kategorije.kategorije',['kategorije'=> $kategorije]);
    }
    public function store()
    {
        $attributes=\request()->validate(['skat'=>['required','alpha','string','max:40','min:1']]);

        Kategorija::create(['Naziv'=> $attributes['skat']]);
        return Redirect::route('indexKategorija');
//        return redirect(route('katIndex'),201);
    }
    public function edit(Kategorija $kategorija)
    {
        return view('kategorije.editkategorija',['kategorija'=>$kategorija]);
    }
    public function update(Kategorija $kategorija)
    {
        $attributes=\request()->validate(['ukat'=>['required','alpha','string','max:40','min:1']]);
        $kategorija->update(['Naziv'=>$attributes['ukat']]);
        return Redirect::route('indexKategorija');
    }
    public function destroy(Kategorija $kategorija)
    {
        Kategorija::destroy($kategorija->SifKat);
        return Redirect::route('indexKategorija');
    }
}
