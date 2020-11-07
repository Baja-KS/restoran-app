<?php

namespace App\Http\Livewire;

use App\Artikal;
use App\Kategorija;
use App\Podkategorija;
use App\Stampac;
use App\VrstaDokumenta;
use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;
use Codedge\Fpdf\Fpdf\PDF_MC_Table;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class KnjigaSanka extends Component
{
    use WithPagination;

    public $search;
    public $sortField;
    public $sortAsc=true;
//    public $artikliDPU;
    public $pice=1;
    public $sifreArtikalaZaDan=[];
    public $prodajaZaDan=[];
    public $nabavkaZaDan=[];


    public function mount()
    {
        $this->search=Carbon::now()->format('Y-m-d');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {

        if($this->sortField===$field)
        {
            $this->sortAsc = !$this->sortAsc;
        }
        else
            $this->sortAsc=true;

        $this->sortField=$field;
    }


    public function preview()
    {
        $date=$this->search;
        if(!$date)
            return;

        $showDate=\DateTime::createFromFormat('Y-m-d',$date);

        $artikli=Artikal::whereIn('PLUKod',$this->sifreArtikalaZaDan)->where(function ($query){
            $pica=Kategorija::where('Naziv','Pica')->first()->podkategorije->pluck('SifKat');
            $pica=$pica->merge(Podkategorija::where('Naziv','Komponente-Pica')->first()->SifKat);
            $hrana=Kategorija::where('Naziv','Hrana')->first()->podkategorije->pluck('SifKat');
            $hrana=$hrana->merge(Podkategorija::where('Naziv','Komponente-Hrana')->first()->SifKat);
            if($this->pice)
                $query->whereIn('Kategorija',$pica);
            else
                $query->whereIn('Kategorija',$hrana);
        })->get();

//        foreach ($artikli as $artikal)
//        {
//
//        }

        $fpdf=new Fpdf('P','mm','A4');
        $fpdf->AddPage();

        $fpdf->setX(30);
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(30,10,'Obrazac DPU',0,0,'L');

        $fpdf->SetX(130);
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(30,10,'Red.br. iz PK-1',0,1,'L');
        $fpdf->Line(160,16,180,16);

        $fpdf->Ln(25);

        $fpdf->SetX(60);
        $fpdf->SetFont('Arial','B',14);
        $fpdf->Cell(60,10,'LIST DNEVNOG PROMETA UGOSTITELJA',0,2,'L');
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(60,10,'za dan '.$showDate->format('m/d/Y').' godine',0,1,'R');

        $fpdf->Ln(5);

        $fpdf->SetX(2);
        $fpdf->SetFont('Arial','B',8);
        if($this->pice)
            $fpdf->Cell(10,10,'Pica','',1,'L');
        else
            $fpdf->Cell(10,10,'Hrana','',1,'L');

        $fpdf->SetX(2);
        $fpdf->SetFont('Arial','B',6);
        $fpdf->Cell(8,10,'R. br','TB',0,'L');
        $fpdf->Cell(22,10,'Naziv','TB',0,'L');
        $fpdf->Cell(12,10,'Stopa PDV','TB',0,'L');
        $fpdf->Cell(5,10,'JM','TB',0,'L');
        $fpdf->Cell(15,10,'Preneta kol.','TB',0,'L');
        $fpdf->Cell(15,10,'Nabavna kol.','TB',0,'L');
        $fpdf->Cell(15,10,'Ukupno','TB',0,'L');

        $fpdf->Cell(14,5,'Zalihe na','T',2,'L');
        $fpdf->Cell(14,5,'kraju dana','B',0,'L');
        $fpdf->SetY(80,false);

        $fpdf->Cell(15,5,'Utrosena kol.','T',2,'L');
        $fpdf->Cell(15,5,'u toku dana','B',0,'L');
        $fpdf->SetY(80,false);

        $fpdf->Cell(20,5,"Prodajna cena po",'T',2,'L');
        $fpdf->Cell(20,5,"j. mere sa PDV",'B',0,'L');
        $fpdf->SetY(80,false);

//        $fpdf->Cell(15,5,'Zalihe na','T',2,'L');
//        $fpdf->Cell(15,5,'kraju dana','B',0,'L');
//        $fpdf->SetY(80,false);

        $fpdf->Cell(32,5,'Ostvareni promet od usluga','TB',2,'L');
        $fpdf->Cell(16,5,'od pica','RB',0,'L');
        $fpdf->Cell(16,5,'od hrane','LB',0,'L');
        $fpdf->SetY(80,false);

        $fpdf->Cell(30,10,'Prodajna vrednost nabavke','TB',1,'L');

        //w -> 8 22 12 5 15 15 15 14 15 20 16 16 30
        //h -> 10

        $fpdf->SetFont('Arial','',6);
//        dd($artikli);
        $ukupniPromet=0;
        $ukupnaPVNabavke=0;
        foreach ($artikli as $i=>$artikal)
        {
            $preneta=$artikal->magacin->prenetaKolicinaDatuma($date);
            $nabavna=$this->nabavkaZaDan[$artikal->PLUKod] ?? 0;
            $utroseno=$this->prodajaZaDan[$artikal->PLUKod] ?? 0;

//            $grupa=$artikal->podkategorija->glavnaKategorija->Naziv;
            $ukupniPromet+=$artikal->grupa()->Naziv!='Komponente' ? $artikal->magacin->ZadnjaProdajnaCena : $artikal->magacin->ZadnjaNabavnaCena*$utroseno;
            $ukupnaPVNabavke+=$artikal->grupa()->Naziv!='Komponente' ? $artikal->magacin->ZadnjaProdajnaCena : $artikal->magacin->ZadnjaNabavnaCena*$nabavna;

            $fpdf->SetX(2);
            $fpdf->Cell(8,10,$i+1,'TB',0,'L');
            $fpdf->Cell(22,10,$artikal->Naziv,'TB',0,'L');
            $fpdf->Cell(12,10,$artikal->poreskastopa->Vrednost.'%','TB',0,'L');
            $fpdf->Cell(5,10,$artikal->jedinicamere->Naziv,'TB',0,'L');
            $fpdf->Cell(15,10,$preneta,'TB',0,'L');
            $fpdf->Cell(15,10,$nabavna,'TB',0,'L');
            $fpdf->Cell(15,10,$preneta+$nabavna,'TB',0,'L');
            $fpdf->Cell(14,10,$preneta+$nabavna-$utroseno,'TB',0,'L');
            $fpdf->Cell(15,10,$utroseno,'TB',0,'L');
            $fpdf->Cell(20,10,$artikal->grupa()->Naziv!='Komponente' ? $artikal->magacin->ZadnjaProdajnaCena : $artikal->magacin->ZadnjaNabavnaCena,'TB',0,'L');
            $fpdf->Cell(16,10,$this->pice ? ($artikal->grupa()->Naziv!='Komponente' ? $artikal->magacin->ZadnjaProdajnaCena : $artikal->magacin->ZadnjaNabavnaCena)*$utroseno : '-','TB',0,'L');
            $fpdf->Cell(16,10,!$this->pice ? ($artikal->grupa()->Naziv!='Komponente' ? $artikal->magacin->ZadnjaProdajnaCena : $artikal->magacin->ZadnjaNabavnaCena)*$utroseno : '-','TB',0,'L');
            $fpdf->Cell(30,10,($artikal->grupa()->Naziv!='Komponente' ? $artikal->magacin->ZadnjaProdajnaCena : $artikal->magacin->ZadnjaNabavnaCena)*$nabavna,'TB',1,'L');
        }
        $fpdf->SetX(-87);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(20,10,'Svega','',0,'L');

        if($this->pice)
            $fpdf->SetX(-67);
        else
            $fpdf->SetX(-47);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(16,10,$ukupniPromet,'TBLR',0,'L');

        $fpdf->SetX(-35);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(30,10,$ukupnaPVNabavke,'TBLR',0,'L');


        $fpdf->SetX(30);
        $fpdf->SetY(-35);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(40,10,'Sastavio','T',0,'C');

        $fpdf->SetX(150);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(40,10,'Odgovorno lice','T',1,'C');

        $fpdf->Output('F','knjigasanka.pdf',true);

        $this->emit('renderPreviewKnjigaSanka');
        $this->emit('openPreviewKnjigaSanka');
    }

    public function closeDPU()
    {
        $this->emit('closePreviewKnjigaSanka');
    }

    public function printDPI()
    {
        $brojPrimeraka=1;
        if(config('app.print'))
        {
            $stampac = Stampac::firma();
            exec('lp -d ' . $stampac->Naziv . ' -n ' . $brojPrimeraka . ' knjigasanka.pdf');
        }
        $this->emit('closePreviewKnjigaSanka');
    }

    public function closeKS()
    {
        $this->emit('closeKnjigaSanka');
    }

    public function render()
    {
//        dd($this->search);
        $idProdaja=VrstaDokumenta::where('Sifra','RCM')->first()->id;
        $idNabavka=VrstaDokumenta::where('Sifra','KLM')->first()->id;

        $nabavka=Artikal::join('tblDokumentaStavke','tblArtikli.PLUKod','=','tblDokumentaStavke.SifraRobe')
            ->join('tblDokumenta','tblDokumentaStavke.IDDOK','=','tblDokumenta.id')
            ->where('Dokument',$idNabavka)
//            ->whereNotIn('VrstaDok',['z'])
//            ->whereDate('tblDokumenta.created_at','like','%'.$this->search.'%')
            ->whereDate('tblDokumenta.created_at','=',$this->search)
            ->selectRaw('PLUKod,sum(Kolicina) as Nabavka')
            ->groupBy('PLUKod');

        $prodaja=Artikal::join('tblDokumentaStavke','tblArtikli.PLUKod','=','tblDokumentaStavke.SifraRobe')
            ->join('tblDokumenta','tblDokumentaStavke.IDDOK','=','tblDokumenta.id')
            ->where('Dokument',$idProdaja)
            ->whereNotIn('VrstaDok',['z'])
//            ->whereDate('tblDokumenta.created_at','like','%'.$this->search.'%')
            ->whereDate('tblDokumenta.created_at','=',$this->search)
            ->selectRaw('PLUKod,sum(Kolicina) as Prodaja')
            ->groupBy('PLUKod');

//        $nabavkaMap=[];
//        $prodajaMap=[];
        $this->nabavkaZaDan=[];
        $this->prodajaZaDan=[];
        $this->sifreArtikalaZaDan=[];

//        dd($this->search);


        foreach ($nabavka->get() as $stavka)
            $this->nabavkaZaDan[$stavka->PLUKod]=$stavka->Nabavka;
        foreach ($prodaja->get() as $stavka) {
            $artikal=Artikal::find($stavka->PLUKod);
            if(!$artikal->Normativ)
                $this->prodajaZaDan[$stavka->PLUKod] = $stavka->Prodaja;
            else
                foreach ($artikal->komponente as $komponenta)
                    $this->prodajaZaDan[$komponenta->PLUKod]=$stavka->Prodaja*Artikal::kolicinaUMesavini($artikal,$komponenta);
        }

        $this->sifreArtikalaZaDan=array_merge(array_keys($this->nabavkaZaDan),array_keys($this->prodajaZaDan));

//        Log::notice('Nabavka:');
//        Log::notice($nabavkaMap);
//        Log::notice('Prodaja:');
//        Log::notice($prodajaMap);



        return view('livewire.knjiga-sanka',[
            'artikliDPU'=>Artikal::whereIn('PLUKod',$this->sifreArtikalaZaDan)
                ->where(function ($query){
                    $kategorijePicaId=Kategorija::where('Naziv','Pica')->first()->podkategorije->pluck('SifKat');
                    $kategorijePicaId=$kategorijePicaId->merge(Podkategorija::where('Naziv','Komponente-Pica')->first()->SifKat);
                    $kategorijeHranaId=Kategorija::where('Naziv','Hrana')->first()->podkategorije->pluck('SifKat');
                    $kategorijeHranaId=$kategorijeHranaId->merge(Podkategorija::where('Naziv','Komponente-Hrana')->first()->SifKat);
                    if($this->pice)
                        $query->whereIn('Kategorija',$kategorijePicaId);
                    else
                        $query->whereIn('Kategorija',$kategorijeHranaId);
                })
                ->paginate(5),
//            'prodaja'=>$prodajaMap,
//            'nabavka'=>$nabavkaMap
        ]);
    }
}
