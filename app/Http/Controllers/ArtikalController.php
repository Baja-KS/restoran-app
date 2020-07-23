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
        $artikli=Artikal::paginate(5);
        return view('artikli.artikli',['artikli'=>$artikli]);
    }

    public function show(Artikal $artikal)
    {
        return view('artikli.showartikal',['artikal'=>$artikal]);
    }

    public function create()
    {
        return view('artikli.createartikal',[
            'artikli'=>Artikal::all(),
            'kategorije'=> Podkategorija::all(),
            'jedinicemere'=> Jedinicamere::all(),
            'poreskestope'=> PoreskaStopa::all()
        ]);
    }

    public function store()
    {
        $generalAttributes=\request()->validate([
            'naziv'=>['required','string'],
            'kolicinaulaza'=>['numeric','nullable'],
            'kolicinaizlaza'=>['numeric','nullable'],
            'zadnjaprodajnacena'=>['required','numeric'],
            'zadnjanabavnacena'=>['required','numeric']
        ]);
        $normativ=\request('normativ') ? true : false;
        $aktivan=\request('aktivan') ? true : false;
        Artikal::create([
            'PLUKod'=>Artikal::sledeciPLUKod(),
            'Naziv'=>$generalAttributes['naziv'],
            'Kategorija'=>\request('kategorija'),
            'Jedinicamere'=>\request('jedinicamere'),
            'BarKod'=>Artikal::sledeciPLUKod(),
            'Radnik'=>auth()->user()->PK,
            'PoreskaStopa'=>\request('poreskastopa'),
            'Normativ'=>$normativ,
            'Aktivan'=>$aktivan
        ]);
        $noviArtikal=Artikal::where('PLUKod',Artikal::trenutniPLUKod())->first();
        StavkaMagacina::create([
            'SifraArtikla'=>$noviArtikal->PLUKod,
            'KolicinaUlaza'=>$generalAttributes['kolicinaulaza'],
            'KolicinaIzlaza'=>$generalAttributes['kolicinaizlaza'],
            'ZadnjaProdajnaCena'=>$generalAttributes['zadnjaprodajnacena'],
            'ZadnjaNabavnaCena'=>$generalAttributes['zadnjanabavnacena'],
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
            $noviArtikal->magacin()->update([
                'KolicinaUlaza'=>0,
                'KolicinaIzlaza'=>0
            ]);
        }
        return Redirect::route('indexArtikal');
    }

    public function edit(Artikal $artikal)
    {
        return view('artikli.editartikal',[
            'artikli'=>Artikal::all(),
            'artikal'=>$artikal,
            'kategorije'=> Podkategorija::all(),
            'jedinicemere'=> Jedinicamere::all(),
            'poreskestope'=> PoreskaStopa::all()
        ]);
    }

    public function update(Artikal $artikal)
    {
        $generalAttributes=\request()->validate([
            'naziv'=>['required','string'],
            'kolicinaulaza'=>['numeric','nullable'],
            'kolicinaizlaza'=>['numeric','nullable'],
            'zadnjaprodajnacena'=>['required','numeric'],
            'zadnjanabavnacena'=>['required','numeric'],
            'prodavnica'=>['required','numeric']
        ]);
        $normativ=\request('normativ') ? true : false;
        $aktivan=\request('aktivan') ? true : false;
        $artikal->update([
            'Naziv'=>$generalAttributes['naziv'],
            'Kategorija'=>\request('kategorija'),
            'Jedinicamere'=>\request('jedinicamere'),
            'PoreskaStopa'=>\request('poreskastopa'),
            'Normativ'=>$normativ,
            'Aktivan'=>$aktivan
        ]);
        $artikal->magacin()->update([
            'KolicinaUlaza'=>$generalAttributes['kolicinaulaza'],
            'KolicinaIzlaza'=>$generalAttributes['kolicinaizlaza'],
            'ZadnjaProdajnaCena'=>$generalAttributes['zadnjaprodajnacena'],
            'ZadnjaNabavnaCena'=>$generalAttributes['zadnjanabavnacena'],
            'Prodavnica'=>$generalAttributes['prodavnica']
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
            $artikal->magacin->update([
                'KolicinaUlaza'=>0,
                'KolicinaIzlaza'=>0
            ]);
        }
        return Redirect::route('indexArtikal');
    }

    public function destroy(Artikal $artikal)
    {
        Artikal::destroy($artikal->PLUKod);
        return Redirect::route('indexArtikal');
    }
}
