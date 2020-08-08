<?php

namespace App\Http\Controllers;

use App\Stampac;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class StampacController extends Controller
{
//    private $akcije=['sank','kuhinja','racun','firma'];
//
//    private function dostupneAkcije()
//    {
//        $dostupneAkcije=[];
//
//        foreach ($this->akcije as $akcija)
//        {
//
//        }
//    }

    public function index()
    {
        return view('stampaci.createstampaci',['stampaci'=>Stampac::all(),'dostupniStampaci'=>Stampac::dostupniStampaci(),'akcije'=>Stampac::dostupneAkcije()]);
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
        return view('stampaci.editstampaci',['stampaci'=>Stampac::all(),'dostupniStampaci'=>Stampac::dostupniStampaci(),'stampac'=>$stampac,'akcije'=>Stampac::dostupneAkcije()]);
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
