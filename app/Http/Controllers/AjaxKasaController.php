<?php

namespace App\Http\Controllers;

use App\Artikal;
use App\Komitent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AjaxKasaController extends Controller
{

    public function show(Request $request)
    {
       $komitent=Komitent::where('Sifra',$request->id)->first();
       $popust=$komitent->Popust;
       return response()->json([
           'popust'=>$popust
       ]);
    }
}
