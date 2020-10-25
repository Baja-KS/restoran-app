<?php

namespace App\Http\Livewire;

use App\Artikal;
use App\Dokument;
use App\Firma;
use App\Http\Controllers\KasaController;
use App\Komitent;
use App\Stampac;
use App\VrstaDokumenta;
use Codedge\Fpdf\Fpdf\Fpdf;
use Livewire\Component;
use Livewire\WithPagination;

class ListaRacuna extends Component
{
    use WithPagination;

    public $search;
    public $sortField;
    public $sortAsc=true;
    public $gotovinski;
//    public $loadPDF=false;


    protected $paginationTheme='bootstrap';

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

//    protected $listeners=['renderNoviRacun'=>'$refresh'];

    public function preview(Dokument $dokument,$gotovinski)
    {
//        $this->loadPDF=false;
        $firma=$dokument->komitent;
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
        $fpdf->Cell(50,10,date_format($dokument->created_at,'d/m/Y'),0,0,'L');

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
        $fpdf->Cell(50,10,date_format($dokument->created_at,'d/m/Y'),0,0,'L');

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
        if (!$gotovinski)
            $fpdf->Cell(100,10,'Racun-Otpremnica',0,0,'L');
        else
            $fpdf->Cell(100,10,'Gotovinski racun',0,0,'L');
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(40,10,'Broj fiskalnog isecka: ',0,0,'L');
        $fpdf->Cell(20,10,$dokument->BrFiskal,0,1,'R');

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

            foreach ($dokument->stavke as $index=>$stavka)
            {
                $fpdf->Cell(20,10,$index+1,'B',0,'L');
                $fpdf->Cell(20,10,$stavka->artikal->PLUKod,'B',0,'L');
                $fpdf->Cell(40,10,$stavka->artikal->Naziv,'B',0,'L');
                $fpdf->Cell(10,10,$stavka->artikal->jedinicamere->Naziv,'B',0,'L');
                $fpdf->Cell(10,10,$stavka->Kolicina,'B',0,'L');
                $fpdf->Cell(30,10,$stavka->ProdCena,'B',0,'L');
                $fpdf->Cell(20,10,'0','B',0,'L');
                $fpdf->Cell(20,10,$stavka->artikal->poreskastopa->Vrednost,'B',0,'L');
                $fpdf->Cell(20,10,round($stavka->ProdCena-Artikal::bezPDVa($stavka->ProdCena,$stavka->artikal->poreskastopa->Vrednost),2),'B',1,'L');
            }

        $fpdf->SetX(120);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(40,10,'Ukupan iznos za uplatu: ',0,0,'L');
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(40,10,$dokument->Ukupno1,0,1,'R');

        $fpdf->SetX(40);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(40,10,'Iznos PDV:  '.($firma->PDV ? '20%' : '0%'),'TLR',1,'L');
        $fpdf->SetX(40);
        $fpdf->Cell(40,10,'Vrednost sa PDV:  '.$dokument->Ukupno1,'BLR',1,'L');

        $fpdf->SetFont('Arial','I','10');
        $fpdf->Cell(40,20,'Napomena: '.$dokument->Napomena ?? '',0,1,'L');


        $fpdf->SetFont('Arial','B',10);
        $fpdf->SetX(100);
        $fpdf->SetY(230);
        $fpdf->Cell(100,10,'Fakturisao',0,0,'L');
        $fpdf->Cell(70,10,'Primio',0,1,'R');
        $fpdf->Line(30,250,70,250);
        $fpdf->Line(140,250,180,250);


            $fpdf->Output('F', 'racunfirma.pdf', true);
//            exec('lp -d '.$stampac->AkcijaStampaca.' racun.pdf');
//            if(config('app.print'))
//            {
//                $stampac=Stampac::firma();
//                exec('lp -d ' . $stampac->Naziv . ' -n ' . ' firma.pdf');
//            }
        $this->emit('renderNoviRacun');
//        $this->loadPDF=true;
        $this->emit('previewRacun');
    }

    public function print()
    {
        if(config('app.print'))
            {
                $stampac=Stampac::firma();
                exec('lp -d ' . $stampac->Naziv . ' -n ' . ' racunfirma.pdf');
            }
        $this->emit('printRacun');
    }

    public function close()
    {
//        $this->loadPDF=false;
        $this->emit('printRacun');
    }

    public function render()
    {
        $dokID=VrstaDokumenta::where('Sifra','RCM')->first()->id;
        return view('livewire.lista-racuna',['racuni'=>Dokument::where('Dokument',$dokID)
            ->whereNotNull('SifKom')
            ->where(function ($query){
                $query->where('Kartica',0);
                if($this->gotovinski)
                    $query->where('Gotovina','>',0);
                else
                    $query->where('Cek','>',0);
            })
            ->join('tblKomitenti','tblDokumenta.SifKom','=','tblKomitenti.Sifra')
        ->where(function ($query){
            $query->where('tblDokumenta.BrDok','like','%'.$this->search.'%')
                ->orWhere('tblDokumenta.created_at','like','%'.$this->search.'%')
                ->orWhere('tblDokumenta.Ukupno1','like','%'.$this->search.'%')
                ->orWhere('tblKomitenti.Naziv','like','%'.$this->search.'%');
        })->when($this->sortField,function ($query){
            $query->orderBy($this->sortField,$this->sortAsc ? 'asc' : 'desc');
        })->paginate(5),'path'=>'/Restoran/public/racunfirma.pdf']);
    }
}
