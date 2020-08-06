<?php

namespace App\Http\Controllers;

use App\Kategorija;
use App\Podkategorija;
use Illuminate\Http\Request;

class GrupaAjaxController extends Controller
{
    public function show(Request $request)
    {
        $kategorija=Podkategorija::where('SifKat',$request->kategorija)->first();
        $grupaID=$kategorija->glavnaKategorija->SifKat;
        return response()->json(array(
           'grupa'=>$grupaID
        ),200);
    }
}
