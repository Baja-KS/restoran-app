<?php

namespace App\Http\Controllers;

use App\Dokument;
use App\VrstaDokumenta;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProdajaController extends Controller
{
    public function index()
    {
        return view('prodajakonobara.prodajakonobara',['svi'=>false]);
    }

    public function indexSvi()
    {
        return view('prodajakonobara.prodajakonobara',['svi'=>true]);
    }

    public function dnevna()
    {
        $vrstaDok=VrstaDokumenta::where('Sifra','RCM')->first();
        $racuni=$vrstaDok->dokumenti()->where('Radnik',auth()->user()->PK)->whereDate('created_at','=',Carbon::today()->toDateString())->latest()->paginate(5);
        return view('prodajakonobara.prodajakonobaraTabela',[
            'svi'=>false,
            'racuni'=>$racuni,
            'datum'=>false
        ]);
    }

    public function dnevnaSvi()
    {
        $vrstaDok=VrstaDokumenta::where('Sifra','RCM')->first();
        $racuni=$vrstaDok->dokumenti()->latest()->whereDate('created_at','=',Carbon::today()->toDateString())->paginate(5);
        return view('prodajakonobara.prodajakonobaraTabela',[
            'svi'=>true,
            'racuni'=>$racuni,
            'datum'=>false
        ]);
    }

    public function nedeljna()
    {
        $vrstaDok=VrstaDokumenta::where('Sifra','RCM')->first();
        $racuni=$vrstaDok->dokumenti()->where('Radnik',auth()->user()->PK)->whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->latest()->paginate(5);
        return view('prodajakonobara.prodajakonobaraTabela',[
            'svi'=>false,
            'racuni'=>$racuni,
            'datum'=>false
        ]);
    }

    public function nedeljnaSvi()
    {
        $vrstaDok=VrstaDokumenta::where('Sifra','RCM')->first();
        $racuni=$vrstaDok->dokumenti()->latest()->whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->paginate(5);
        return view('prodajakonobara.prodajakonobaraTabela',[
            'svi'=>true,
            'racuni'=>$racuni,
            'datum'=>false
        ]);
    }

    public function mesecna()
    {
        $vrstaDok=VrstaDokumenta::where('Sifra','RCM')->first();
        $racuni=$vrstaDok->dokumenti()->where('Radnik',auth()->user()->PK)->whereBetween('created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])->latest()->paginate(5);
        return view('prodajakonobara.prodajakonobaraTabela',[
            'svi'=>false,
            'racuni'=>$racuni,
            'datum'=>false
        ]);
    }
    public function mesecnaSvi()
    {
        $vrstaDok=VrstaDokumenta::where('Sifra','RCM')->first();
        $racuni=$vrstaDok->dokumenti()->latest()->whereBetween('created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])->paginate(5);
        return view('prodajakonobara.prodajakonobaraTabela',[
            'svi'=>true,
            'racuni'=>$racuni,
            'datum'=>false
        ]);
    }

    public function odDo()
    {
        $vrstaDok=VrstaDokumenta::where('Sifra','RCM')->first();
        $racuni=$vrstaDok->dokumenti()->latest()->whereBetween('created_at',[\request('od'),\request('do')])->paginate(5);
        return view('prodajakonobara.prodajakonobaraTabela',[
            'svi'=>false,
            'racuni'=>$racuni,
            'datum'=>true,
            'od'=>date('d/m/Y',strtotime(\request('od'))),
            'do'=>date('d/m/Y',strtotime(\request('do')))
        ]);
    }

    public function odDoSvi()
    {
        $vrstaDok=VrstaDokumenta::where('Sifra','RCM')->first();
        $racuni=$vrstaDok->dokumenti()->latest()->whereBetween('created_at',[\request('od'),\request('do')])->paginate(5);
        return view('prodajakonobara.prodajakonobaraTabela',[
            'svi'=>true,
            'racuni'=>$racuni,
            'datum'=>true,
            'od'=>date('d/m/Y',strtotime(\request('od'))),
            'do'=>date('d/m/Y',strtotime(\request('do')))
        ]);
    }

    public function show(Dokument $dokument)
    {
        return view('prodajakonobara.detaljiracuna',[
            'racun'=>$dokument,
            'svi'=>false,
            'stavke'=>$dokument->stavke()->paginate(5)
        ]);
    }
}
