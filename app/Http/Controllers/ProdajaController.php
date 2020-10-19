<?php

namespace App\Http\Controllers;

use App\Dokument;
use App\VrstaDokumenta;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\UnauthorizedException;

class ProdajaController extends Controller
{
    public function index($svi)
    {
        if($svi)
            if(\Illuminate\Support\Facades\Gate::denies('admin'))
                throw new UnauthorizedException("Admins only");
        return view('prodajakonobara.prodajakonobara',['svi'=>$svi]);
    }


    public function pregledProdaje($svi,$tipPregleda)
    {
        $dan=false;
        $customDatum=false;
        $od=null;
        $do=null;
        $vrstaDok=VrstaDokumenta::where('Sifra','RCM')->first();
        $racuni=$vrstaDok->dokumenti();
        if($svi)
        {
            if(\Illuminate\Support\Facades\Gate::denies('admin'))
                throw new UnauthorizedException("Admins only");
            $racuni=$racuni->latest();
        }
        else
            $racuni=$racuni->where('Radnik',auth()->user()->PK);
        switch ($tipPregleda)
        {
            case "dan":
                $dan=true;
                $od=Carbon::today()->toDateString();
                break;
            case "nedelja":
                $od=Carbon::now()->startOfWeek();
                $do=Carbon::now()->endOfWeek();
                break;
            case "mesec":
                $od=Carbon::now()->startOfMonth();
                $do=Carbon::now()->endOfMonth();
                break;
            default:
                $customDatum=true;
                $od=\request('od');
                $do=\request('do');
        }
        if($dan)
            $racuni=$racuni->whereDate('created_at','=',$od);
        else
            $racuni=$racuni->whereBetween('created_at',[$od,$do]);
        if(!$svi)
            $racuni=$racuni->latest();
        $racuni=$racuni->paginate(5);

        return view('prodajakonobara.prodajakonobaraTabela',[
            'svi'=>$svi,
            'racuni'=>$racuni,
            'datum'=>$customDatum,
            'od'=>$customDatum ? date('d/m/Y',strtotime(\request('od'))) : null,
            'do'=>$customDatum ? date('d/m/Y',strtotime(\request('do'))) : null
        ]);

    }


    public function show(Dokument $dokument,$svi)
    {
        return view('prodajakonobara.detaljiracuna',[
            'racun'=>$dokument,
            'svi'=>$svi,
            'stavke'=>$dokument->stavke()->paginate(5)
        ]);
    }
}
