<?php

namespace App\Http\Controllers;

use App\OrganizacionaJedinica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class OrganizacionajedinicaController extends Controller
{
    public function index()
    {
        return view('orgjedinice.createorgjedinice',['organizacionejedinice'=>OrganizacionaJedinica::all()]);
    }

    public function show(OrganizacionaJedinica $organizacionajedinica)
    {
        return view('orgjedinice.showorgjedinice',['organizacionajedinica'=>$organizacionajedinica,'organizacionejedinice'=>OrganizacionaJedinica::all()]);
    }
    public function store()
    {
        $attributes=\request()->validate([
            'vrsta'=>['required','string','size:1'],
            'naziv'=>['required','string'],
            'adresa'=>['string','nullable'],
            'postbr'=>['numerical','nullable','digits:5'],
            'mesto'=>['string','nullable'],
            'telefon'=>['numerical','nullable'],
            'odglice'=>['string','nullable']
        ]);
        OrganizacionaJedinica::create([
            'Vrsta'=>$attributes['vrsta'],
            'Naziv'=>$attributes['naziv'],
            'Adresa'=>$attributes['adresa'],
            'PostBr'=>$attributes['postbr'],
            'Mesto'=>$attributes['mesto'],
            'Telefon'=>$attributes['telefon'],
            'OdgLice'=>$attributes['odglice']
        ]);
        return Redirect::route('indexOrganizacionajedinica');
    }

    public function edit(OrganizacionaJedinica $organizacionajedinica)
    {
        return view('orgjedinice.editorgjedinice',['organizacionajedinica'=>$organizacionajedinica,'organizacionejedinice'=>OrganizacionaJedinica::all()]);
    }

    public function update(OrganizacionaJedinica $organizacionajedinica)
    {
        $attributes=\request()->validate([
            'vrsta'=>['required','string','size:1'],
            'naziv'=>['required','string'],
            'adresa'=>['string','nullable'],
            'postbr'=>['numerical','nullable','digits:5'],
            'mesto'=>['string','nullable'],
            'telefon'=>['numerical','nullable'],
            'odglice'=>['string','nullable']
        ]);
        $organizacionajedinica->update([
            'Vrsta'=>$attributes['vrsta'],
            'Naziv'=>$attributes['naziv'],
            'Adresa'=>$attributes['adresa'],
            'PostBr'=>$attributes['postbr'],
            'Mesto'=>$attributes['mesto'],
            'Telefon'=>$attributes['telefon'],
            'OdgLice'=>$attributes['odglice']
        ]);
        return Redirect::route('indexOrganizacionajedinica');
    }

    public function destroy(OrganizacionaJedinica $organizacionajedinica)
    {
        OrganizacionaJedinica::destroy($organizacionajedinica->SifOj);
        return Redirect::route('indexOrganizacionajedinica');
    }
}
