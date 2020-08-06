<?php

namespace App\Http\Controllers;

use App\Artikal;
use App\Jedinicamere;
use App\Kategorija;
use App\Podkategorija;
use App\PoreskaStopa;
use App\StavkaMagacina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ArtikalController extends Controller
{
    public function index()
    {
        $artikli=Artikal::orderBy('created_at','desc')->paginate(5);
        return view('artikli.artikli',['artikli'=>$artikli]);
    }

    public function show(Artikal $artikal)
    {
        return view('artikli.showartikal',['artikal'=>$artikal]);
    }

    public function create()
    {
        return view('artikli.createartikal',[
            'artikli'=>Kategorija::where('Naziv','Komponente')->first()->artikli(),
            'kategorije'=> Podkategorija::all(),
            'jedinicemere'=> Jedinicamere::all(),
            'poreskestope'=> PoreskaStopa::all(),
            'grupe'=>Kategorija::all(),
            'kom'=>Jedinicamere::where('Naziv','kom')->first()
        ]);
    }

    public function store()
    {
        $generalAttributes=\request()->validate([
            'naziv'=>['required','string'],
            'kategorija'=>['required','numeric'],
            'poreskastopa'=>['required','numeric'],
        ]);
        $normativ=\request('normativ') ? true : false;
        $aktivan=\request('aktivan') ? true : false;
        $jedinica=$normativ ? DB::table('tblIJM')->where('Naziv','kom')->pluck('JMID')->first() : \request('jedinicamere');
        Artikal::create([
            'PLUKod'=>Artikal::sledeciPLUKod(),
            'Naziv'=>$generalAttributes['naziv'],
            'Kategorija'=>$generalAttributes['kategorija'],
            'Jedinicamere'=>$jedinica,
            'BarKod'=>Artikal::sledeciPLUKod(),
            'Radnik'=>auth()->user()->PK,
            'PoreskaStopa'=>$generalAttributes['poreskastopa'],
            'Normativ'=>$normativ,
            'Aktivan'=>$aktivan
        ]);
        $noviArtikal=Artikal::where('PLUKod',Artikal::trenutniPLUKod())->first();
        StavkaMagacina::create([
            'SifraArtikla'=>$noviArtikal->PLUKod,
            'KolicinaUlaza'=>0,
            'KolicinaIzlaza'=>0,
            'ZadnjaProdajnaCena'=>0,
            'ZadnjaNabavnaCena'=>0,
            'Prodavnica'=>auth()->user()->Objekat
        ]);
        if ($normativ)
        {
            $size=count(\request('komponenta'));
            for ($i=0;$i<$size;$i++)
            {
                DB::table('tblMesavine')->insert([
                    'ArtikalID'=>$noviArtikal->PLUKod,
                    'KomponentaID'=>\request('komponenta')[$i],
                    'Kolicina'=> \request('kolicina')[$i]
                ]);
            }
        }
        return Redirect::route('indexArtikal');
    }

    public function edit(Artikal $artikal)
    {
        return view('artikli.editartikal',[
            'artikli'=>Kategorija::where('Naziv','Komponente')->first()->artikli(),
            'artikal'=>$artikal,
            'kategorije'=> Podkategorija::all(),
            'grupe'=>Kategorija::all(),
            'jedinicemere'=> Jedinicamere::all(),
            'poreskestope'=> PoreskaStopa::all(),
            'kom'=>Jedinicamere::where('Naziv','kom')->first()
        ]);
    }

    public function update(Artikal $artikal)
    {
        $generalAttributes=\request()->validate([
            'naziv'=>['required','string'],
            'kategorija'=>['required','numeric'],
            'poreskastopa'=>['required','numeric'],
        ]);
        $normativ=\request('normativ') ? true : false;
        $aktivan=\request('aktivan') ? true : false;
        $jedinica=$normativ ? DB::table('tblIJM')->where('Naziv','kom')->pluck('JMID')->first() : \request('jedinicamere');
        $artikal->update([
            'Naziv'=>$generalAttributes['naziv'],
            'Kategorija'=>$generalAttributes['kategorija'],
            'PoreskaStopa'=>$generalAttributes['poreskastopa'],
            'Jedinicamere'=>$jedinica,
            'Normativ'=>$normativ,
            'Aktivan'=>$aktivan
        ]);
        if ($normativ)
        {
            $size=count(\request('komponenta'));
            DB::table('tblMesavine')->where('ArtikalID',$artikal->PLUKod)->delete();
            for ($i=0;$i<$size;$i++)
            {
                DB::table('tblMesavine')->insert([
                    'ArtikalID'=>$artikal->PLUKod,
                    'KomponentaID'=>\request('komponenta')[$i],
                    'Kolicina'=> \request('kolicina')[$i]
                ]);
            }
        }
        return Redirect::route('indexArtikal');
    }

    public function destroy(Artikal $artikal)
    {
        Artikal::destroy($artikal->PLUKod);
        return Redirect::route('indexArtikal');
    }
}
