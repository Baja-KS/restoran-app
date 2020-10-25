<?php

namespace App\Http\Controllers;

use App\Artikal;
use App\Dokument;
use App\DokumentStavka;
use App\Firma;
use App\Jedinicamere;
use App\Komitent;
use App\OrganizacionaJedinica;
use App\PoreskaStopa;
use App\Stampac;
use App\VrstaDokumenta;
use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class PrijemnicaController extends Controller
{
    public function index()
    {
        return view('administracija.indexprijemnica',['prijemnice'=>Dokument::prijemniceZaPaginate()->paginate(5)]);
    }
//    public function tableIndex(Request $request)
//    {
//        if ($request->ajax())
//        {
//            $prijemnice=Dokument::prijemnice();
//            return \datatables()->of($prijemnice)->toJson();
//        }
//    }
    public function create()
    {
        return view('administracija.prijemnicaform',[
            'prijemnice'=>Dokument::prijemnice(),
            'artikli'=>Artikal::zaPrijemnicu(),
            'komitenti'=>Komitent::all(),
            'brPrijemnice'=>Dokument::sledeciBrDok(VrstaDokumenta::where('Sifra','KLM')->first()),
            'datumPrijemnice'=>Carbon::now()->format("d/m/Y"),
            'bezPdv'=>0,
            'iznosPdv'=>0,
            'saPdv'=>0,
            'edit'=>false,
            'prijemnica'=>null
            ]);
    }

    public function sifraPromena(Request $request)
    {
        $artikal=Artikal::where('PLUKod',$request->sifra)->first();
        $jm=$artikal->jedinicamere->Naziv;
        $pdv=$artikal->poreskastopa->Vrednost;
        return response()->json(['jm'=>$jm,'pdv'=>$pdv],200);
    }

    public function store()
    {
        $generalAttributes=\request()->validate([
            'komitent'=>['required'],
            'brdok'=>['required']
        ]);
        $idVrsteDok=VrstaDokumenta::where('Sifra','KLM')->first()->id;
        $idOrgJed=OrganizacionaJedinica::where('Vrsta','R')->first()->SifOj;
        Dokument::create([
            'Dokument'=>$idVrsteDok,
            'BrDok'=>Dokument::sledeciBrDok(VrstaDokumenta::where('Sifra','KLM')->first()),
            'BrVezanogDok'=>Dokument::sledeciBrVezanogDok(),
            'SifKom'=>$generalAttributes['komitent'],
            'SifOj1'=>auth()->user()->Objekat,
            'SifOj2'=>$idOrgJed,
            'Napomena'=>\request('napomena'),
            'Dan'=>(new \DateTime(Firma::first()->created_at))->diff(new \DateTime(date("Y-m-d H:i:s")))->days,
            'BrFiskal'=>$generalAttributes['brdok'],
            'DatumF'=>date("Y-m-d"),
            'VremeF'=>date("H:i"),
            'Radnik'=>auth()->user()->PK,
            'BrojStola'=>0,
            'Ukupno1'=>0,
            'Placeno'=>0
        ]);
        $idDok=Dokument::all()->last()->id;
        $size=count(\request('sifra'));
        for ($i=0;$i<$size;$i++)
        {
            DokumentStavka::create([
                'IDDOK'=>$idDok,
                'SifraRobe'=>\request('sifra')[$i],
                'Kolicina'=>\request('kolicina')[$i],
                'NabCena'=>\request('nc')[$i],
                'Rabat'=>\request('rabat')[$i],
                'ProdCena'=>0,
                'Odstampano'=>false
            ]);
        }
        return Redirect::route('indexPrijemnica');
    }

    public function proknjizi(Dokument $dokument)
    {
        if (!$dokument->IndikatorKnjizenja) {
            $dokument->knjizenje();
        }
        return Redirect::route('indexPrijemnica');
    }

    public function destroy(Dokument $dokument)
    {
        if (!$dokument->IndikatorKnjizenja)
            Dokument::destroy($dokument->id);
        return Redirect::route('indexPrijemnica');
    }

    public function edit(Dokument $dokument)
    {
        $bezPdv=0;
        $iznosPdv=0;
        $saPdv=0;
        foreach ($dokument->stavke as $stavka)
        {
            $nc=$stavka->NabCena;
            $rabat=$stavka->Rabat;
            $kol=$stavka->Kolicina;
            $pstopa=$stavka->artikal->poreskastopa->Vrednost;
            $saRabatom=$nc-($rabat/100)*$nc;
            $nv=$saRabatom*$kol;
            $iPdv=$nv*($pstopa/100);
            $nvpdv=$nv+$iPdv;
            $bezPdv+=$nv;
            $iznosPdv+=$iPdv;
            $saPdv+=$nvpdv;
        }

        return view('administracija.prijemnicaform',[
            'prijemnica'=>$dokument,
            'edit'=>true,
            'prijemnice'=>Dokument::prijemnice(),
            'artikli'=>Artikal::zaPrijemnicu(),
            'komitenti'=>Komitent::all(),
            'bezPdv'=>$bezPdv,
            'iznosPdv'=>$iznosPdv,
            'saPdv'=>$saPdv,
            'brPrijemnice'=>$dokument->BrDok,
            'datumPrijemnice'=>date_format($dokument->created_at,"d/m/Y"),
        ]);
    }

    public function update(Dokument $dokument)
    {
        if ($dokument->IndikatorKnjizenja)
            return Redirect::route('indexPrijemnica');
        $generalAttributes=\request()->validate([
            'komitent'=>['required'],
            'brdok'=>['required','numeric']
        ]);
        $dokument->update([
            'SifKom'=>$generalAttributes['komitent'],
            'Napomena'=>\request('napomena'),
            'BrFiskal'=>$generalAttributes['brdok'],
        ]);
        DokumentStavka::destroy($dokument->stavke->pluck('id'));
        $size=count(\request('sifra'));
        for ($i=0;$i<$size;$i++)
        {
            DokumentStavka::create([
                'IDDOK'=>$dokument->id,
                'SifraRobe'=>\request('sifra')[$i],
                'Kolicina'=>\request('kolicina')[$i],
                'NabCena'=>\request('nc')[$i],
                'Rabat'=>\request('rabat')[$i],
                'ProdCena'=>0,
                'Odstampano'=>false
            ]);
        }
        return Redirect::route('indexPrijemnica');
    }

    public function pregled(Dokument $dokument)
    {

        $firma=Firma::all()->first();

        $fpdf=new Fpdf('P','mm','A4');
        $fpdf->AddPage();

        $fpdf->setX(10);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(30,10,'Naziv firme: ',0,0,'L');
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(30,10,$firma->Naziv,0,0,'L');

        $fpdf->setX(130);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(30,10,'Dobavljac: ',0,0,'L');
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(30,10,$dokument->komitent->Naziv,0,1,'L');

        $fpdf->setX(10);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(30,10,'Adresa: ',0,0,'L');
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(30,10,$firma->Adresa ?? '/',0,0,'L');

        $fpdf->setX(130);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(30,10,'Adresa: ',0,0,'L');
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(30,10,$dokument->komitent->Adresa ?? '/',0,1,'L');

        $fpdf->setX(10);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(30,10,'PIB: ',0,0,'L');
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(30,10,$firma->PIB,0,0,'L');

        $fpdf->setX(130);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(30,10,'PIB: ',0,0,'L');
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(30,10,$dokument->komitent->PIB,0,1,'L');

        $fpdf->setX(10);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(30,10,'Sediste: ',0,0,'L');
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(30,10,$firma->Mesto ?? "/",0,0,'R');

        $fpdf->setX(130);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(30,10,'Sediste: ',0,0,'L');
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(30,10,$dokument->komitent->Mesto ?? "/",0,1,'R');


//        $fpdf->Ln(5);

        $fpdf->setX(10);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(30,10,'Broj i datum dokumenta: ',0,0,'L');
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(50,10,$dokument->BrDok." od ".date_format($dokument->created_at,'d/m/Y'),0,1,'R');

        $fpdf->setX(10);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(30,10,'Objekat: ',0,0,'L');
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(30,10,$dokument->orgJedinica->Naziv,0,1,'R');


        //        $fpdf->Line(10,50,199,50);
        $fpdf->Ln(5);

        $fpdf->Line(10,70,199,70);

        $fpdf->SetX(70);
        $fpdf->SetFont('Arial','B',18);
        $fpdf->Cell(100,10,'PRIJEMNICA ROBE',0,2,'L');
        $fpdf->SetFont('Arial','B',14);
        $fpdf->Cell(100,10,'u '.$dokument->orgJedinica->Naziv.' br. '.$dokument->BrDok.'/'.date_format($dokument->created_at,'Y'),0,1,'L');

        $fpdf->Ln(5);

        $fpdf->SetX(2);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(10,10,'R. br','LTB',0,'L');
        $fpdf->Cell(12,10,'Sifra','TB',0,'L');
        $fpdf->Cell(30,10,'Naziv Artikla','TB',0,'L');
        $fpdf->Cell(10,10,'JM','TB',0,'L');
        $fpdf->Cell(20,10,'% PDV','TB',0,'L');
        $fpdf->Cell(10,10,'Kol.','TB',0,'L');
        $fpdf->Cell(20,10,'Fakt. cena','TB',0,'L');
        $fpdf->Cell(20,10,'% Rabat','TB',0,'L');
        $fpdf->Cell(25,10,'Nab. vred.','TB',0,'L');
        $fpdf->Cell(25,10,'Prod. cena','TB',0,'L');
        $fpdf->Cell(25,10,'Prod. vred.','TBR',1,'L');



        $fpdf->SetFont('Arial','',10);

        foreach ($dokument->stavke as $i=>$stavka)
        {
            $fpdf->SetX(2);
            $cenaSaRabatom=$stavka->NabCena-($stavka->Rabat/100)*$stavka->NabCena;
            $vrSaRabatom=$cenaSaRabatom*$stavka->Kolicina;
            $vrSaPdv=$vrSaRabatom+($stavka->artikal->poreskastopa->Vrednost/100)*$vrSaRabatom;
//            $fpdf->Cell(10,10,"WTF",'TB',0,'L');
            $fpdf->Cell(10,10,$i+1,'TB',0,'L');
            $fpdf->Cell(12,10,$stavka->artikal->PLUKod,'TB',0,'L');
            $fpdf->Cell(30,10,$stavka->artikal->Naziv,'TB',0,'L');
            $fpdf->Cell(10,10,$stavka->artikal->jedinicamere->Naziv,'TB',0,'L');
            $fpdf->Cell(20,10,$stavka->artikal->poreskastopa->Vrednost,'TB',0,'L');
            $fpdf->Cell(10,10,$stavka->Kolicina,'TB',0,'L');
            $fpdf->Cell(20,10,$stavka->NabCena,'TB',0,'L');
            $fpdf->Cell(20,10,$stavka->Rabat,'TB',0,'L');
            $fpdf->Cell(25,10,$vrSaPdv,'TB',0,'L');
            $fpdf->Cell(25,10,$stavka->artikal->magacin->ZadnjaProdajnaCena,'TB',0,'L');
            $fpdf->Cell(25,10,$stavka->artikal->magacin->ZadnjaProdajnaCena*$stavka->Kolicina,'TB',1,'L');
        }
        $fpdf->Ln(5);
        $fpdf->SetFont('Arial','B',12);
        $fpdf->setX(10);
        $fpdf->Cell(90,10,'SPECIFIKACIJA PDV PO TARIFAMA I STOPAMA','B',1,'L');
//        $fpdf->Line(10,100,90,100);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->setX(10);
        $fpdf->Cell(30,10,'Stopa','B',0,'L');
        $fpdf->Cell(30,10,'Preth. PDV','B',0,'L');
        $fpdf->Cell(40,10,'Vrednost bez PDV','B',0,'L');
        $fpdf->Cell(40,10,'Vrednost sa PDV','B',1,'L');

        $poreskeStope=PoreskaStopa::all();
        $fpdf->SetFont('Arial','',10);
        foreach ($poreskeStope as $ps)
        {
            $bezPdv=0;
            foreach ($dokument->stavke as $stavka)
            {
                if($stavka->artikal->poreskastopa->Vrednost === $ps->Vrednost)
                {
                    $bezPdv+=$stavka->Kolicina*($stavka->NabCena-($stavka->Rabat/100)*$stavka->NabCena);
                }
            }
            $saPdv=$bezPdv+($ps->Vrednost/100)*$bezPdv;
            $fpdf->Cell(30,10,$ps->Vrednost.'%','',0,'L');
            $fpdf->Cell(30,10,'-','',0,'L');
            $fpdf->Cell(40,10,$bezPdv,'',0,'L');
            $fpdf->Cell(40,10,$saPdv,'',1,'L');
        }
        $ukupnoSaPdv=0;
        foreach ($dokument->stavke as $stavka)
        {
            $cenaSaRabatom=$stavka->NabCena-($stavka->Rabat/100)*$stavka->NabCena;
            $vrSaRabatom=$cenaSaRabatom*$stavka->Kolicina;
            $vrSaPdv=$vrSaRabatom+($stavka->artikal->poreskastopa->Vrednost/100)*$vrSaRabatom;
            $ukupnoSaPdv+=$vrSaPdv;
        }

        $fpdf->Ln(10);

        $fpdf->SetX(40);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(80,10,'UKUPNO ZA PRIJEMNICU','TBLR',1,'L');
        $fpdf->SetX(40);
        $fpdf->Cell(80,10,'Iznos fakture od dobavljaca:  '.'-','LR',1,'L');
        $fpdf->SetX(40);
        $fpdf->Cell(80,10,'Prenet porez:  '.'-','LR',1,'L');
        $fpdf->SetX(40);
        $fpdf->Cell(80,10,'Nabavna vrednost sa PDV:  '.$ukupnoSaPdv,'BLR',1,'L');


        $fpdf->SetX(30);
        $fpdf->SetY(-35);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(40,10,'Operater','T',0,'C');

        $fpdf->SetX(150);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(40,10,'Odgovorno lice','T',1,'C');

        $fpdf->Output('F','prijemnica.pdf',true);
//        $brojPrimeraka=1;
//        if(config('app.print'))
//        {
//            $stampac = Stampac::firma();
//            exec('lp -d ' . $stampac->Naziv . ' -n ' . $brojPrimeraka . ' prijemnica.pdf');
//        }
        return view('administracija.previewprijemnica');
    }

    public function stampa()
    {
        $brojPrimeraka=1;
        if(config('app.print'))
        {
            $stampac = Stampac::firma();
            exec('lp -d ' . $stampac->Naziv . ' -n ' . $brojPrimeraka . ' prijemnica.pdf');
        }
        return Redirect::route('indexPrijemnica');
    }
}
