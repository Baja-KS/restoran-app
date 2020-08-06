<?php

namespace App\Http\Controllers;

use App\Kategorija;
use App\Podkategorija;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PodkategorijaController extends Controller
{
    public function index(Kategorija $kategorija)
    {
        $podkategorije=$kategorija->podkategorije()->paginate(7);
        return view('kategorije.podkategorije',['podkategorije'=>$podkategorije , 'kategorija'=>$kategorija]);
    }
    public function store(Kategorija $kategorija)
    {
        $attributes=\request()->validate(['spod'=>['required','string','max:40','min:1']]);
        Podkategorija::create(['Naziv'=>$attributes['spod'],'GlavnaKategorija'=>$kategorija->SifKat]);
        return Redirect::route('indexPodkategorija',$kategorija->SifKat);
    }
    public function edit(Podkategorija $podkategorija)
    {
//        $kategorija=$podkategorija->glavnaKategorija;
        return view('kategorije.editpodkategorija',['podkategorija'=>$podkategorija]);
    }
    public function update(Podkategorija $podkategorija)
    {
        $attributes=\request()->validate(['upod'=>['required','string','max:40','min:1']]);
        $podkategorija->update(['Naziv'=>$attributes['upod']]);
        return Redirect::route('indexPodkategorija',$podkategorija->glavnaKategorija->SifKat);
    }
    public function destroy(Podkategorija $podkategorija)
    {
        Podkategorija::destroy($podkategorija->SifKat);
        return Redirect::route('indexPodkategorija',$podkategorija->glavnaKategorija->SifKat);
    }
}
