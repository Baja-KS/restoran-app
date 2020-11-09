<?php

namespace App\Http\Controllers;

use App\Artikal;
use App\Firma;
use App\Komitent;
use App\OtvorenRacun;
use App\OtvorenRacunStavka;
use App\Podkategorija;
use App\Stampac;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\Storage;
use Livewire\Response;
use phpDocumentor\Reflection\File;
use PHPUnit\Util\Printer;

class KasaController extends Controller
{

    private function zaSank(OtvorenRacun $otvorenRacun)
    {
        $stavke=$otvorenRacun->zaSank();
        if ($stavke->count())
        {
            $fpdf=new Fpdf('P','mm',array(58,100));
            $fpdf->AddPage();

            $fpdf->SetFont('Arial','B',10);
            $fpdf->Cell(15,5,'Nalog Sanku',0,1,'L');

            $fpdf->SetFont('Arial','B',8);
            $fpdf->Cell(15,5,'Sto broj '.$otvorenRacun->Sto,0,1,'L');

            $fpdf->SetFont('Arial','B',8);
            $fpdf->Cell(15,5,'Naziv',0,0,'L');
            $fpdf->SetX(30);
            $fpdf->Cell(10,5,'Kolicina',0,1,'R');

            $fpdf->Line(5,20,55,20);
            $fpdf->Ln(1);

            $fpdf->SetFont('Arial','',6);

            foreach ($stavke as $stavka)
            {
                //utf8_decode(iconv('UTF-8','windows-1250',$stavka->artikal->Naziv))
                $fpdf->Cell(15,5,$stavka->artikal->Naziv,0,0,'L');
                $fpdf->Cell(10,5,$stavka->Kolicina,0,1,'R');
            }
//        $fpdf->IncludeJS("print();");
            $fpdf->Output('F','sank.pdf',true);

            if(config('app.print')) {
                $stampac=Stampac::sank();
                exec('lp -d ' . $stampac->Naziv . ' sank.pdf');
            }
            else
                \session()->flash('Sank','sank.pdf');
        }
    }
    private function zaKuhinju(OtvorenRacun $otvorenRacun)
    {
        $stavke=$otvorenRacun->zaKuhinju();
        if ($stavke->count())
        {
            $fpdf=new Fpdf('P','mm',array(58,100));
            $fpdf->AddPage();

            $fpdf->SetFont('Arial','B',10);
            $fpdf->Cell(15,5,'Nalog Kuhinji',0,1,'L');

            $fpdf->SetFont('Arial','B',8);
            $fpdf->Cell(15,5,'Sto broj '.$otvorenRacun->Sto,0,1,'L');

            $fpdf->SetFont('Arial','B',8);
            $fpdf->Cell(15,5,'Naziv',0,0,'L');
            $fpdf->SetX(30);
            $fpdf->Cell(10,5,'Kolicina',0,1,'R');

            $fpdf->Line(5,20,55,20);
            $fpdf->Ln(1);

            $fpdf->SetFont('Arial','',6);

            foreach ($stavke as $stavka)
            {
                $fpdf->Cell(15,5,$stavka->artikal->Naziv,0,0,'L');
                $fpdf->Cell(10,5,$stavka->Kolicina,0,1,'R');
            }
//        $fpdf->IncludeJS("print();");
            $fpdf->Output('F','kuhinja.pdf',true);
            if(config('app.print'))
            {
                $stampac=Stampac::kuhinja();
                exec('lp -d ' . $stampac->Naziv . ' kuhinja.pdf');
            }
            else
                \session()->flash('Kuhinja','kuhinja.pdf');
        }

    }
    private function izdajRacun($racuni,$nacinPlacanja,$placeno=null,$preview=false)
    {
        $firma=Firma::all()->first();
        $fpdf=new Fpdf('P','mm',array(58,200));
        $fpdf->AddPage();

        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(15,5,$firma->Naziv,0,1,'L');

        $fpdf->SetFont('Arial','B',8);
        $fpdf->Cell(15,5,'PIB:'.$firma->PIB,0,1,'L');

        $fpdf->Line(5,20,55,20);
        $fpdf->Ln(1);

        $fpdf->SetFont('Arial','',6);

//        $visina=0;
        foreach ($racuni as $racun) {
            foreach ($racun->stavke as $stavka) {
                $fpdf->Cell(10, 5, $stavka->artikal->PLUKod, 0, 0, 'L');
                $fpdf->Cell(15, 5, $stavka->artikal->Naziv, 0, 1, 'L');

                $fpdf->Cell(5, 5, $stavka->Kolicina . 'x', 0, 0, 'L');
                $fpdf->Cell(10, 5, $stavka->cenaSaPopustom(), 0, 0, 'L');
                $fpdf->Cell(10, 5, ($stavka->Kolicina * $stavka->cenaSaPopustom()), 0, 1, 'R');
            }
        }
//        $fpdf->Line(5,$visina,55,$visina);
        $fpdf->Ln(5);
        $fpdf->Cell(15,5,'Za uplatu: ',0,0,'L');
        $fpdf->Cell(10,5,$racuni->sum('UkupnaCena'),0,1,'R');

        if ($preview)
        {
//            if ($nacinPlacanja == 'Gotovina') {
//                $fpdf->Cell(15, 5, 'Uplaceno: ', 0, 1, 'L');
////                $fpdf->Cell(10, 5, $placeno, 0, 1, 'R');
//            } else {
//                $fpdf->Cell(15, 5, $nacinPlacanja . ': ', 0, 0, 'L');
////                $fpdf->Cell(10, 5, $racuni->sum('UkupnaCena'), 0, 1, 'R');
//            }
            $fpdf->Output('F', 'racunpreview.pdf', true);
        }
        else
        {
            if ($nacinPlacanja == 'Gotovina') {
                $fpdf->Cell(15, 5, 'Uplaceno: ', 0, 0, 'L');
                $fpdf->Cell(10, 5, $placeno, 0, 1, 'R');
            } else {
                $fpdf->Cell(15, 5, $nacinPlacanja . ': ', 0, 0, 'L');
                $fpdf->Cell(10, 5, $racuni->sum('UkupnaCena'), 0, 1, 'R');
            }

            $fpdf->Cell(15, 5, 'Povracaj: ', 0, 0, 'L');
            $fpdf->Cell(10, 5, ($nacinPlacanja == 'Gotovina' ? $placeno - $racuni->sum('UkupnaCena') : 0), 0, 1, 'R');

            $fpdf->Output('F', 'racun.pdf', true);
//            exec('lp -d '.$stampac->AkcijaStampaca.' racun.pdf');
            if(config('app.print'))
            {
                $stampac=Stampac::racun();
                exec('lp -d ' . $stampac->Naziv . ' racun.pdf');
            }
            else
            {
                session()->flash('izdatRacun','racun.pdf');
            }
        }
    }

    public function izdajRacunFirma($racuni,$nacinPlacanja,$firma,$brIsecka,$preview=false,$brojPrimeraka=1)
    {
        $firma=Komitent::where('Sifra',$firma)->first();
        $izdaje=Firma::all()->first();

        $fpdf=new Fpdf('P','mm','A4');
        $fpdf->AddPage();

        $fpdf->setX(130);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(30,10,'Naziv firme: ',0,0,'L');
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(30,10,$izdaje->Naziv,0,1,'L');

        $fpdf->setX(130);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(30,10,'Adresa: ',0,0,'L');
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(30,10,$izdaje->Adresa ?? '/',0,1,'L');

        $fpdf->setX(130);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(30,10,'PIB: ',0,0,'L');
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(30,10,$izdaje->PIB,0,1,'L');

        $fpdf->setX(130);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(30,10,'Tek.racun: ',0,0,'L');
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(30,10,$izdaje->TekuciRacun ?? "/",0,1,'R');

        $fpdf->Line(10,50,199,50);
        $fpdf->Ln(1);

        $fpdf->SetX(10);
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(50,10,'Datum fakturisanja: ',0,0,'L');
        $fpdf->Cell(50,10,date('d-m-Y'),0,0,'L');

        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(50,10,'Firma: ','TL',0,'R');
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(49,10,$firma->Naziv,'TR',1,'L');

        $fpdf->SetX(10);
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(50,10,'Mesto fakturisanja: ',0,0,'L');
        $fpdf->Cell(50,10,'Krusevac',0,0,'L');

        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(50,10,'PIB: ','L',0,'R');
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(49,10,$firma->PIB,'R',1,'L');

        $fpdf->SetX(10);
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(50,10,'Datum prometa dobara: ',0,0,'L');
        $fpdf->Cell(50,10,date('d-m-Y'),0,0,'L');

        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(50,10,'Adresa: ','L',0,'R');
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(49,10,$firma->Adresa,'R',1,'L');

        $fpdf->SetX(10);
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(50,10,'Mesto prometa dobara: ',0,0,'L');
        $fpdf->Cell(50,10,'Krusevac',0,0,'L');

        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(50,10,'Mesto: ','BL',0,'R');
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(49,10,$firma->Mesto ?? "/",'BR',1,'L');

        /*$fpdf->SetX(110);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(50,10,'Tel: ','BL',0,'R');
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(49,30,$firma->Telefon ?? "/",'BR',1,'L');*/

        $fpdf->SetX(30);
        $fpdf->SetFont('Arial','B',18);
        if ($nacinPlacanja=='Cek')
            $fpdf->Cell(100,10,'Racun-Otpremnica',0,0,'L');
        else
            $fpdf->Cell(100,10,'Gotovinski racun',0,0,'L');
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(40,10,'Broj fiskalnog isecka: ',0,0,'L');
        $fpdf->Cell(20,10,($preview ? "x" : $brIsecka),0,1,'R');

        $fpdf->SetX(10);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(20,10,'Red. broj','LTB',0,'L');
        $fpdf->Cell(20,10,'Sifra Artikla','TB',0,'L');
        $fpdf->Cell(40,10,'Naziv Artikla','TB',0,'L');
        $fpdf->Cell(10,10,'JM','TB',0,'L');
        $fpdf->Cell(10,10,'Kol.','TB',0,'L');
        $fpdf->Cell(30,10,'Prod. cena','TB',0,'L');
        $fpdf->Cell(20,10,'% Rabat','TB',0,'L');
        $fpdf->Cell(20,10,'% PDV','TB',0,'L');
        $fpdf->Cell(20,10,'Iznos PDV','TBR',1,'L');

        $fpdf->SetFont('Arial','',10);

        foreach ($racuni as $racun)
        {
            foreach ($racun->stavke as $index=>$stavka)
            {
                $fpdf->Cell(20,10,$index+1,'B',0,'L');
                $fpdf->Cell(20,10,$stavka->artikal->PLUKod,'B',0,'L');
                $fpdf->Cell(40,10,$stavka->artikal->Naziv,'B',0,'L');
                $fpdf->Cell(10,10,$stavka->artikal->jedinicamere->Naziv,'B',0,'L');
                $fpdf->Cell(10,10,$stavka->Kolicina,'B',0,'L');
                $fpdf->Cell(30,10,$stavka->cenaSaPopustom(),'B',0,'L');
                $fpdf->Cell(20,10,'0','B',0,'L');
                $fpdf->Cell(20,10,$stavka->artikal->poreskastopa->Vrednost,'B',0,'L');
                $fpdf->Cell(20,10,round($stavka->cenaSaPopustom()-Artikal::bezPDVa($stavka->cenaSaPopustom(),$stavka->artikal->poreskastopa->Vrednost),2),'B',1,'L');
            }
        }

        $fpdf->SetX(120);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(40,10,'Ukupan iznos za uplatu: ',0,0,'L');
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(40,10,$racuni->sum('UkupnaCena'),0,1,'R');

        $fpdf->SetX(40);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(40,10,'Iznos PDV:  '.($firma->PDV ? '20%' : '0%'),'TLR',1,'L');
        $fpdf->SetX(40);
        $fpdf->Cell(40,10,'Vrednost sa PDV:  '.$racuni->sum('UkupnaCena'),'BLR',1,'L');

        $fpdf->SetFont('Arial','I','10');
        $fpdf->Cell(40,20,'Napomena: '.$racuni->first()->Napomena ?? '',0,1,'L');


        $fpdf->SetFont('Arial','B',10);
        $fpdf->SetX(100);
        $fpdf->SetY(230);
        $fpdf->Cell(100,10,'Fakturisao',0,0,'L');
        $fpdf->Cell(70,10,'Primio',0,1,'R');
        $fpdf->Line(30,250,70,250);
        $fpdf->Line(140,250,180,250);

        if ($preview)
        {
            $fpdf->Output('F','firmapreview.pdf',true);
        }
        else
        {
            $fpdf->Output('F', 'firma.pdf', true);
//            exec('lp -d '.$stampac->AkcijaStampaca.' racun.pdf');
            if(config('app.print'))
            {
                $stampac=Stampac::firma();
                exec('lp -d ' . $stampac->Naziv . ' -n ' . $brojPrimeraka . ' firma.pdf');
            }
            else
                session()->flash('izdatRacunFirma','firma.pdf');
        }





    }

    private function stampajPorudzbinu(OtvorenRacun $otvorenRacun)
    {
        $this->zaSank($otvorenRacun);
        $this->zaKuhinju($otvorenRacun);

        return Redirect::route('home');
    }

    private function formatirajRacun($path,$nacinPlacanja,$placeno,$racuni,Firma $firma)
    {
        $ext='';
        $text='';
        $stavke=collect([]);
        foreach ($racuni as $racun)
            $stavke=$stavke->merge($racun->stavke);
        switch ($firma->FiskalniStampac)
        {
            case 'INTRASTER':
                $ext='.inp';
                foreach ($stavke as $stavka)
                    $text.="107,1,______,_,__;4;".$stavka->artikal->PoreskaStopa.";".$stavka->artikal->PLUKod.";".$stavka->artikal->magacin->ZadnjaProdajnaCena.";".$stavka->artikal->Naziv.";1;NB;".$stavka->artikal->BarKod.";0\n";
                $text.="48,1,______,_,__;1;0000;\n";
                foreach ($stavke as $stavka)
                    $text.="52,1,______,_,__;".$stavka->artikal->PLUKod.";".$stavka->Kolicina.";".$stavka->cenaSaPopustom().";\n";
                $nacinPlacanjaBroj=0;
                switch ($nacinPlacanja){
                    case 'Gotovina':
                        $nacinPlacanjaBroj=0;
                        break;
                    case 'Cek':
                        $nacinPlacanjaBroj=1;
                        $placeno=round($racuni->sum('UkupnaCena'),2);
                        break;
                    case 'Kartica':
                        $nacinPlacanjaBroj=2;
                        $placeno=round($racuni->sum('UkupnaCena'),2);
                        break;
                }
                $text.="53,1,______,_,__;".$nacinPlacanjaBroj.";".$placeno.";\n";
                $text.="56,1,______,_,__;";
                break;
            case 'WINGS':
                $ext='.wng';
                $text.="#FISKAL\n";
                foreach ($stavke as $stavka)
                    $text.=$stavka->artikal->PLUKod."\t".$stavka->artikal->Naziv."\t".$stavka->artikal->jedinicamere->Naziv."\t".$stavka->Kolicina."\t".round($stavka->cenaSaPopustom(),2)."\t".$stavka->artikal->PoreskaStopa."\n";
                $text.="#PLACANJE\n";
                $nacinPlacanjaStr='';
                switch ($nacinPlacanja){
                    case 'Gotovina':
                        $nacinPlacanjaStr='GOTOVINA';
                        break;
                    case 'Cek':
                        $nacinPlacanjaStr='CEKOVI';
                        $placeno=round($racuni->sum('UkupnaCena'),2);
                        break;
                    case 'Kartica':
                        $nacinPlacanjaStr='KARTICA';
                        $placeno=round($racuni->sum('UkupnaCena'),2);
                        break;
                }
                $text.=$nacinPlacanjaStr."\t".$placeno;
                break;
            case 'GENEKO':
                $ext='.inp';
                foreach ($stavke as $stavka)
                    $text.='S,1,______,_,__;'.$stavka->artikal->Naziv.';'.round($stavka->cenaSaPopustom(),2).';'.$stavka->Kolicina.';1;1;'.$stavka->artikal->PoreskaStopa.';0;'.$stavka->artikal->PLUKod.';'."\n";
                $nacinPlacanjaBroj=0;
                switch ($nacinPlacanja){
                    case 'Gotovina':
                        $nacinPlacanjaBroj=0;
                        break;
                    case 'Cek':
                        $nacinPlacanjaBroj=1;
                        $placeno=round($racuni->sum('UkupnaCena'),2);
                        break;
                    case 'Kartica':
                        $nacinPlacanjaBroj=2;
                        $placeno=round($racuni->sum('UkupnaCena'),2);
                        break;
                }
                $text.='T,1,______,_,__;'.$nacinPlacanjaBroj.';'.'<'.$placeno.'>;;;;';
                break;
        }
        $fullpath=$path.'/fiskalniracun'.$ext;
        $file=fopen($fullpath,'w');
        fwrite($file,$text);
        fclose($file);

        \session()->flash('downloadFiskalniRacun',$fullpath);
//        return response()->download(storage_path('app/public/fiskalniracun'.$ext));

//        return $fullpath;
    }

    public function create($sto,$greska=null)
    {
        Gate::authorize('accessKasa',$sto);
        $kategorije=Podkategorija::all();
        $radnik=auth()->user();
        $komitenti=Komitent::all();
        return view('kasa.kasalist',[
            'kategorije'=>$kategorije,
            'radnik'=>$radnik,
            'sto'=>$sto,
            'komitenti'=>$komitenti,
            'greska'=>$greska,
            'ukupno'=>null,
            'index'=>0,
            'racuni'=>null,
            'edit'=>false
        ]);
    }

    public function store($sto)
    {
        Gate::authorize('accessKasa',$sto);
        $size=count(\request('stavkaid') ?? []);
        $popuststavke=[];
//        Log::info(\request('stavka'));
        if ($size==0 and (\request()->input('akcija')==='poruci' or (\request()->input('akcija')==='naplata') and !OtvorenRacun::all()->count()))
        {
            return Redirect::route('home');
        }
        $attributes=\request()->validate([
            'gost'=>['string','nullable'],
            'napomena'=>['string','nullable'],
        ]);


        $otvorenRacunPolja=[
            'Sto'=>$sto,
            'Gost'=>\request('gost'),
            'Radnik'=>auth()->user()->PK,
            'Napomena'=>$attributes['napomena'],
            'UkupnaCena'=>0,
        ];


        $popuststavke=\request('popuststavke');
        $ukupnaCena=0;
        $otvorenRacunStavkePolja=[];
        for ($i=0;$i<$size;$i++)
        {
            $otvorenRacunStavkePolja[]=[
                'brRacuna'=>"",
                'Artikal'=>\request('stavkaid')[$i],
//                'Kolicina'=>\request('stavkakolicina')[$i]-$popust,
                'Kolicina'=>\request('stavkakolicina')[$i],
                'Popust'=>$popuststavke[$i] ?? 0
            ];

//            $popust=$this->Popust;
//            $cena=$this->artikal->magacin->ZadnjaProdajnaCena;
//            $cena-($popust/100*$cena);
            $popust=$popuststavke[$i];
            $kolicina=\request('stavkakolicina')[$i];
            $cena=Artikal::find(\request('stavkaid')[$i])->magacin->ZadnjaProdajnaCena;
            $ukupnaCena+=($cena-($popust/100*$cena))*$kolicina;
        }
        $otvorenRacunPolja['UkupnaCena']=$ukupnaCena;
        if (\request()->input('akcija')==='naplata') {
//            $racuni=OtvorenRacun::where('Sto',$sto)->get();
//            $this->izdajRacun($racuni,'Gotovina',null,true);
            $sviRacuni=OtvorenRacun::where('Sto',$sto)->orderBy('created_at','asc')->get();
            $izabraniRacuni=[];
            $zaNaplatu=\request('zaNaplatu');
//            dd($zaNaplatu);
            if(!$zaNaplatu)
                return back();
            foreach ($sviRacuni as $i=>$racun)
            {
                if(in_array($i,$zaNaplatu)) {
                    $izabraniRacuni[] = $racun->brojRacuna;
                }
            }
//            dd($izabraniRacuni);
//            $racun=OtvorenRacun::merge($izabraniRacuni);
            return $this->naplata($sto,$izabraniRacuni);
        }
        $noviRacun=null;
        if($size)
        {
            OtvorenRacun::create($otvorenRacunPolja);
            $noviRacun = OtvorenRacun::where('Sto', $sto)->latest()->first();
            for ($i = 0; $i < $size; $i++) {
                $otvorenRacunStavkePolja[$i]['brRacuna'] = $noviRacun->brojRacuna;
                OtvorenRacunStavka::create($otvorenRacunStavkePolja[$i]);
            }
            $noviRacun->update(['UkupnaCena'=>$noviRacun->UkupnaCena()]);
        }
        if (\request()->input('akcija')!=='poruci')
        {

            $nacinPlacanja='';
            switch (\request()->input('akcija'))
            {
                case 'zatvorigotovina':
                    $nacinPlacanja='Gotovina';
                    break;
                case 'zatvoricek':
                    $nacinPlacanja='Cek';
                    break;
                case 'zatvorikartica':
                    $nacinPlacanja='Kartica';
                    break;
            }
            $this->zatvori($sto,$nacinPlacanja);
            return Redirect::route('home');
        }

//        $this->stampajPorudzbinu($noviRacun);
        if($noviRacun)
        {
            $this->stampajPorudzbinu($noviRacun);

        }
        return Redirect::route('home');

    }

    public function edit($sto,$greska=null)
    {
        if(Gate::denies('accessKasa',$sto))
            return back();
        Gate::authorize('accessKasa',$sto);
        $kategorije=Podkategorija::all();
        $radnik=auth()->user();
        $komitenti=Komitent::all();
        $racuni=OtvorenRacun::where('Sto',$sto)->orderBy('created_at','asc')->get();
//        $bezPopusta=0;
//        foreach ($racuni as $racun)
//        {
//            $bezPopusta+=(100*$racun->UkupnaCena)/(100-$racun->Popust);
//        }
        return view('kasa.kasalist',[
            'kategorije'=>$kategorije,
            'radnik'=>$radnik,
            'sto'=>$sto,
            'komitenti'=>$komitenti,
            'racuni'=>$racuni,
            'greska'=>$greska,
            'ukupno'=>$racuni->sum('UkupnaCena'),
//            'bezPopusta'=>$bezPopusta,
            'index'=>0,
            'edit'=>true
        ]);
    }

    public function naplata($sto,$brojeviRacuna)
    {
        Gate::authorize('accessKasa',$sto);
        $komitenti=Komitent::all();
        $gostID=OtvorenRacun::find($brojeviRacuna[count($brojeviRacuna)-1])->Gost ?? null;
        $cena=OtvorenRacun::whereIn('brojRacuna',$brojeviRacuna)->sum('UkupnaCena');

//        $racuni=OtvorenRacun::where('Sto',$sto)->get();
        return view('kasa.naplata',[
            'komitenti'=>$komitenti,
//            'racuni'=>$racuni,
            'sto'=>$sto,
            'brojeviRacuna'=>$brojeviRacuna,
            'gostID'=>$gostID,
            'cena'=>$cena
            ]);

    }

    public function naplati($sto)
    {
        Gate::authorize('accessKasa',$sto);
        $nacinPlacanja="";
        $attributes=[];
//        $otvorenRacunPolja=[
//            'Sto'=>\request('Sto'),
//            'Gost'=>\request('Gost'),
//            'Radnik'=>\request('Radnik'),
//            'Napomena'=>\request('Napomena'),
//            'UkupnaCena'=>\request('UkupnaCena')
//        ];
//        $brojStavki=\request('brojStavki');
//        $otvorenRacunStavkePolja=[];
//        for ($i=0;$i<$brojStavki;$i++)
//        {
//            $otvorenRacunStavkePolja[]=[
//                'brRacuna'=>\request('brRacuna')[$i],
//                'Artikal'=>\request('Artikal')[$i],
//                'Kolicina'=>\request('Kolicina')[$i],
//                'Popust'=>\request('Popust')[$i]
//            ];
//        }
        $brojeviRacuna=\request('brojRacuna');
        $racuni=OtvorenRacun::whereIn('brojRacuna',$brojeviRacuna)->where('Sto',$sto)->get();
        switch (\request()->input('placanje'))
        {
            case 'nazad':
//                OtvorenRacun::destroy($zadnjiRacun->brojRacuna);
                return Redirect::route('editKasa',$sto);
//            case 'previewFirma':
//                $this->izdajRacunFirma($racuni,'Cek',\request('firma'),0,true);
//                return $this->naplata($sto);
            case 'gotovina':
                $nacinPlacanja='Gotovina';
                break;
            case 'cek':
                $nacinPlacanja='Cek';
                break;
            case 'kartica':
                $nacinPlacanja='Kartica';
                break;
        }
//        $brojIsecka=\request('brisecka');
        $uplata = \request('uplata') ?? 0;
        if (!\request('stampanjefirma')) {
//            if($brojStavki)
//            {
//                OtvorenRacun::create($otvorenRacunPolja);
//                $noviRacun = OtvorenRacun::where('Sto', $sto)->latest()->first();
//                for ($i = 0; $i < $brojStavki; $i++) {
//                    $otvorenRacunStavkePolja[$i]['brRacuna'] = $noviRacun->brojRacuna;
//                    OtvorenRacunStavka::create($otvorenRacunStavkePolja[$i]);
//                }
//            }
            $fullpath = '';
            $racuni = OtvorenRacun::merge($racuni);
            if ($nacinPlacanja == 'Gotovina') {
                if ($uplata < \request('ukupno'))
                    $uplata = \request('ukupno');
                //                return Redirect::route('editKasa',[$sto,'Nedovoljno sredstava']);
                //            if (\request('stampanjefirma'))
                //                $this->izdajRacunFirma($racuni,$nacinPlacanja,\request('firma'),$brojIsecka);
                $this->izdajRacun($racuni, $nacinPlacanja, $uplata);
                $this->formatirajRacun('storage', $nacinPlacanja, \request('uplata'), $racuni, Firma::all()->first());
            } else {
                //            if (\request('stampanjefirma'))
                //                $this->izdajRacunFirma($racuni,$nacinPlacanja,\request('firma'),$brojIsecka);
                $uplata = \request('ukupno');
                $this->izdajRacun($racuni, $nacinPlacanja);
                $this->formatirajRacun('storage', $nacinPlacanja, 0, $racuni, Firma::all()->first());
            }
        }
        if (\request('stampanjefirma') || \request('idGosta'))
            return $this->naplataZaFirmu($sto,$nacinPlacanja,$uplata,(\request('firma') ?? \request('idGosta')),$racuni);

        foreach ($racuni as $racun)
            $racun->naplati($nacinPlacanja,$uplata);

//        $pos=strrpos($fullpath,'/') ?? 0;
//        $fileName=substr($fullpath,$pos);
//        \response()->download($fullpath,$fileName,);
//        Redirect::to('public');
//        return response()->download(storage_path('app/public/fiskalniracun.inp'));
//        Storage::disk('public')->download('fiskalniracun.inp');
        return Redirect::route('home');

    }

    private function naplataZaFirmu($sto,$nacinPlacanja,$uplata,$komitent,$racuni)
    {
        Gate::authorize('accessKasa',$sto);
//        $brojStavki=count($otvorenRacunStavkePolja);
//        if($brojStavki)
//        {
//            OtvorenRacun::create($otvorenRacunPolja);
//            $noviRacun = OtvorenRacun::where('Sto', $sto)->latest()->first();
//            for ($i = 0; $i < $brojStavki; $i++) {
//                $otvorenRacunStavkePolja[$i]['brRacuna'] = $noviRacun->brojRacuna;
//                OtvorenRacunStavka::create($otvorenRacunStavkePolja[$i]);
//            }
//        }
//        $racuni=OtvorenRacun::where('Sto',$sto)->get();
//        $stavke=collect([]);
//        foreach ($racuni as $racun)
//            $stavke=$stavke->merge($racun->stavke);
        $this->izdajRacunFirma($racuni,$nacinPlacanja,$komitent,0,true);
//        $noviRacun->delete();
        return view('kasa.naplatafirma',[
            'sto'=>$sto,
            'komitent'=>$komitent,
            'nacinPlacanja'=>$nacinPlacanja,
            'uplata'=>$uplata,
            'racuni'=>$racuni
        ]);
    }
    public function naplatiZaFirmu($sto)
    {
        Gate::authorize('accessKasa',$sto);
//        $otvorenRacunPolja=[
//            'Sto'=>\request('Sto'),
//            'Gost'=>\request('Gost'),
//            'Radnik'=>\request('Radnik'),
//            'Napomena'=>\request('Napomena'),
//            'UkupnaCena'=>\request('UkupnaCena')
//        ];
//        $brojStavki=\request('brojStavki');
//        $otvorenRacunStavkePolja=[];
//        for ($i=0;$i<$brojStavki;$i++)
//        {
//            $otvorenRacunStavkePolja[]=[
//                'brRacuna'=>\request('brRacuna')[$i],
//                'Artikal'=>\request('Artikal')[$i],
//                'Kolicina'=>\request('Kolicina')[$i],
//                'Popust'=>\request('Popust')[$i]
//            ];
//        }
//        OtvorenRacun::create($otvorenRacunPolja);
//        $noviRacun = OtvorenRacun::where('Sto', $sto)->latest()->first();
//        for ($i = 0; $i < $brojStavki; $i++) {
//            $otvorenRacunStavkePolja[$i]['brRacuna'] = $noviRacun->brojRacuna;
//            OtvorenRacunStavka::create($otvorenRacunStavkePolja[$i]);
//        }
        $firma=\request('firma');
        $nacinPlacanja=\request('nacinplacanja');
        $brIsecka=\request('brisecka');
        $brPrimeraka=\request('brprimeraka');
        $brojeviRacuna=\request('brojeviRacuna');
        $racuni=OtvorenRacun::whereIn('brojRacuna',$brojeviRacuna)->where('Sto',$sto)->get();
        $uplata = \request('uplata') ?? 0;
        $racuni=OtvorenRacun::merge($racuni);
        if ($nacinPlacanja == 'Gotovina') {
            if ($uplata < \request('ukupno'))
                $uplata = \request('ukupno');
            $this->izdajRacun($racuni, $nacinPlacanja, $uplata);
            $this->formatirajRacun('storage', $nacinPlacanja, \request('uplata'), $racuni, Firma::all()->first());
        } else {
            $uplata = \request('ukupno');
            $this->izdajRacun($racuni, $nacinPlacanja);
            $this->formatirajRacun('storage', $nacinPlacanja, 0, $racuni, Firma::all()->first());
        }
        $this->izdajRacunFirma($racuni,$nacinPlacanja,$firma,$brIsecka,false,$brPrimeraka);
        foreach ($racuni as $racun)
            $racun->naplati($nacinPlacanja,$racun->UkupnaCena,false,$brIsecka);
        return Redirect::route('home');
    }

    private function zatvori($sto,$nacinPlacanja)
    {
        Gate::authorize('accessKasa',$sto);
        $racuni=OtvorenRacun::where('Sto',$sto)->get();
        foreach ($racuni as $racun)
            $racun->zatvori($nacinPlacanja,$racun->UkupnaCena);
        return Redirect::route('home');
    }


}
