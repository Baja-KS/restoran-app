<?php

namespace App\Http\Controllers;

use App\Stampac;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class StampacController extends Controller
{
    public function index()
    {
        return view('stampaci.createstampaci',['stampaci'=>Stampac::all(),'akcije'=>['sank','kuhinja','racun','firma']]);
    }

    public function store()
    {
        $attributes=\request()->validate([
            'naziv'=>['required','string'],
            'akcija'=>['required','string']
        ]);
        Stampac::create([
            'Naziv'=>$attributes['naziv'],
            'AkcijaStampaca'=>$attributes['akcija']
        ]);
        return Redirect::route('indexStampac');
    }

    public function edit(Stampac $stampac)
    {
        return view('stampaci.editstampaci',['stampaci'=>Stampac::all(),'stampac'=>$stampac,'akcije'=>['sank','kuhinja','racun','firma']]);
    }

    public function update(Stampac $stampac)
    {
        $attributes=\request()->validate([
            'naziv'=>['required','string'],
            'akcija'=>['required','string']
        ]);
        $stampac->update([
            'Naziv'=>$attributes['naziv'],
            'AkcijaStampaca'=>$attributes['akcija']
        ]);
        return Redirect::route('indexStampac');
    }

    public function destroy(Stampac $stampac)
    {
        Stampac::destroy($stampac->StampacID);
        return Redirect::route('indexStampac');
    }
}
