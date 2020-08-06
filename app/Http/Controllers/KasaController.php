<?php

namespace App\Http\Controllers;

use App\Artikal;
use App\Komitent;
use App\OtvorenRacun;
use App\OtvorenRacunStavka;
use App\Podkategorija;
use Codedge\Fpdf\Fpdf\Fpdf_autoprint;
use Codedge\Fpdf\Fpdf\Fpdf_Javascript;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Codedge\Fpdf\Fpdf\Fpdf;
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
            exec('lp -d sank sank.pdf');
//        return Redirect::route('home');
//        exit();
        }
    }
    private function zaKuhinju(OtvorenRacun $otvorenRacun)
    {
        $stavke=$otvorenRacun->zaKuhinju();
        if ($stavke->count())
        {
            $fpdf=new Fpdf_autoprint('P','mm',array(58,100));
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
            exec('lp -d kuhinja kuhinja.pdf');
//            $opSys=php_uname('s');
//            if ($opSys=='Linux')
//                exec('lp -d kuhinja kuhinja.pdf');
//            elseif (strtoupper(substr($opSys, 0, 3)) === 'WIN')

//        exit();
        }

    }
    private function stampajPorudzbinu(OtvorenRacun $otvorenRacun)
    {
        $this->zaSank($otvorenRacun);
        $this->zaKuhinju($otvorenRacun);
        return Redirect::route('home');
    }


    public function create($sto,$greska=null)
    {
        $kategorije=Podkategorija::all();
        $radnik=auth()->user();
        $komitenti=Komitent::all();
        return view('kasa.createkasa',[
            'kategorije'=>$kategorije,
            'radnik'=>$radnik,
            'sto'=>$sto,
            'komitenti'=>$komitenti,
            'greska'=>$greska,
            'ukupno'=>null
        ]);
    }

    public function store($sto)
    {
        $size=count(\request('stavkaid') ?? []);
        $ukupnaCena=0;
        if ($size==0)
        {
            return Redirect::route('home');
        }
        else
        {
            for ($i=0;$i<$size;$i++)
            {
                $artikal=Artikal::where('PLUKod',\request('stavkaid')[$i])->first();
                $kolicina=\request('stavkakolicina')[$i];


                $rezervisanaKolicina=OtvorenRacunStavka::where('Artikal',$artikal->PLUKod)->sum('Kolicina');
                if ($rezervisanaKolicina + $kolicina > $artikal->magacin->naStanju())
                {
                    if (OtvorenRacun::brojRacunaZaSto($sto)>0)
                    {
                        return Redirect::route('editKasa',[$sto,$artikal->Naziv." nema dovoljno na stanju.Na stanju: ".$artikal->magacin->naStanju()]);
                    }
                    return Redirect::route('createKasa',[$sto,$artikal->Naziv." nema dovoljno na stanju.Na stanju: ".$artikal->magacin->naStanju()]);
                }


            }
            for ($i=0;$i<$size;$i++)
            {
                $artikal=Artikal::where('PLUKod',\request('stavkaid')[$i])->first();
                $cena=$artikal->magacin->ZadnjaProdajnaCena;
                $kolicina=\request('stavkakolicina')[$i];
                $ukupnaCena+=$cena*$kolicina;
            }
        }

        $attributes=\request()->validate([
            'gost'=>['string','nullable'],
//            'bezPopusta'=>['numeric','float'],
//            'ukupnacena'=>['numeric','float'],
//            'popust'=>['numeric'],
            'napomena'=>['string','nullable'],
        ]);
        $popust=\request('popust') ?? 0;
        if ($attributes['gost'] and !\request('popust'))
        {
            $popust=Komitent::where('Sifra',$attributes['gost'])->pluck('Popust')->first();
        }
        $ukupnaCena-=($popust/100*$ukupnaCena);
        OtvorenRacun::create([
            'Sto'=>$sto,
            'Gost'=>$attributes['gost'],
            'Radnik'=>auth()->user()->PK,
            'Napomena'=>$attributes['napomena'],
            'UkupnaCena'=>$ukupnaCena,
            'Popust'=>$popust
        ]);
        $noviRacun=OtvorenRacun::where('Sto',$sto)->latest()->first();

        for ($i=0;$i<$size;$i++)
        {
            OtvorenRacunStavka::create([
                'brRacuna'=>$noviRacun->brojRacuna,
                'Artikal'=>\request('stavkaid')[$i],
                'Kolicina'=>\request('stavkakolicina')[$i]
            ]);
        }
//        $this->stampajPorudzbinu($noviRacun);
        $this->stampajPorudzbinu($noviRacun);
        return Redirect::route('home');

    }

    public function edit($sto,$greska=null)
    {
        $kategorije=Podkategorija::all();
        $radnik=auth()->user();
        $komitenti=Komitent::all();
        $racuni=OtvorenRacun::where('Sto',$sto)->get();
        $bezPopusta=0;
        foreach ($racuni as $racun)
        {
            $bezPopusta+=(100*$racun->UkupnaCena)/(100-$racun->Popust);
        }
        return view('kasa.editkasa',[
            'kategorije'=>$kategorije,
            'radnik'=>$radnik,
            'sto'=>$sto,
            'komitenti'=>$komitenti,
            'racuni'=>$racuni,
            'greska'=>$greska,
            'ukupno'=>$racuni->sum('UkupnaCena'),
            'bezPopusta'=>$bezPopusta
        ]);
    }

    public function naplata($sto)
    {

    }

    public function naplati($sto)
    {

    }

    public function zatvaranje($sto)
    {

    }

    public function zatvori($sto)
    {

    }


}
