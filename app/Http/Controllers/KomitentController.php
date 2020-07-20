<?php

namespace App\Http\Controllers;

use App\Komitent;
use Illuminate\Http\Request;
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

    }
    public function store()
    {

    }
    public function edit(Komitent $komitent)
    {

    }
    public function update(Komitent $komitent)
    {

    }
    public function delete(Komitent $komitent)
    {
        Komitent::destroy($komitent->Sifra);
        return Redirect::route('komIndex');
    }
}
