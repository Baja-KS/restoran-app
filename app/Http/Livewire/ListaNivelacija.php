<?php

namespace App\Http\Livewire;

use App\Dokument;
use App\Firma;
use App\PoreskaStopa;
use App\Stampac;
use App\VrstaDokumenta;
use Codedge\Fpdf\Fpdf\Fpdf;
use Livewire\Component;
use Livewire\WithPagination;

class ListaNivelacija extends Component
{
    use WithPagination;

    public $search;
    public $sortField;
    public $sortAsc=true;


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

    public function preview(Dokument $dokument)
    {
        $firma=Firma::all()->first();

        $fpdf=new Fpdf('P','mm','A4');
        $fpdf->AddPage();

        $fpdf->setX(10);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(30,10,'Naziv firme: ',0,0,'L');
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(30,10,$firma->Naziv,0,1,'L');


        $fpdf->setX(10);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(30,10,'Adresa: ',0,0,'L');
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(30,10,$firma->Adresa ?? '/',0,1,'L');


        $fpdf->setX(10);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(30,10,'PIB: ',0,0,'L');
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(30,10,$firma->PIB,0,1,'L');


        $fpdf->setX(10);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(30,10,'Sediste: ',0,0,'L');
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(30,10,$firma->Mesto ?? "/",0,1,'R');



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
        $fpdf->Cell(100,10,'NIVELACIJA ROBE',0,2,'L');
        $fpdf->SetFont('Arial','B',14);
        $fpdf->Cell(100,10,'br. '.$dokument->BrDok.'/'.date_format($dokument->created_at,'Y'),0,1,'L');

        $fpdf->Ln(5);

        $fpdf->SetX(2);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(10,10,'R. br','LTB',0,'L');
        $fpdf->Cell(12,10,'Sifra','TB',0,'L');
        $fpdf->Cell(30,10,'Naziv Artikla','TB',0,'L');
        $fpdf->Cell(10,10,'JM','TB',0,'L');
        $fpdf->Cell(20,10,'% PDV','TB',0,'L');
        $fpdf->Cell(10,10,'Kol.','TB',0,'L');
        $fpdf->Cell(30,10,'Zadnja Prod. Cena','TB',0,'L');
        $fpdf->Cell(30,10,'Nova Prod. Cena','TB',0,'L');
        $fpdf->Cell(25,10,'Razlika u Ceni','TB',0,'L');
        $fpdf->Cell(25,10,'Vrednost PDV','TBR',1,'L');



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
            $fpdf->Cell(30,10,$stavka->StaraProdajnaCena,'TB',0,'L');
            $fpdf->Cell(30,10,$stavka->ProdCena,'TB',0,'L');
            $fpdf->Cell(25,10,round($stavka->razlikaUCeni(),2),'TB',0,'L');
            $fpdf->Cell(25,10,round($stavka->vrednostPDVpoRazlici(),2),'TB',1,'L');
        }
        $fpdf->Ln(5);

        $fpdf->Ln(10);

        $fpdf->SetX(40);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(80,10,'UKUPNO ZA NIVELACIJU','TBLR',1,'L');
        $fpdf->SetX(40);
        $fpdf->Cell(80,10,'Razlika u Ceni:  '.round($dokument->razlikaUCeni(),2),'LR',1,'L');
        $fpdf->SetX(40);
        $fpdf->Cell(80,10,'Vrednost PDV:  '.round($dokument->vrednostPDVpoRazlici(),2),'BLR',1,'L');


        $fpdf->SetX(30);
        $fpdf->SetY(-35);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(40,10,'Operater','T',0,'C');

        $fpdf->SetX(150);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(40,10,'Odgovorno lice','T',1,'C');

        $fpdf->Output('F','nivelacija.pdf',true);

        $this->emit('renderNivelacija');
        $this->emit('previewNivelacija');

    }

    public function print()
    {
        $brojPrimeraka=1;
        if(config('app.print'))
        {
            $stampac = Stampac::firma();
            exec('lp -d ' . $stampac->Naziv . ' -n ' . $brojPrimeraka . ' nivelacija.pdf');
        }
        $this->emit('printNivelacija');
    }

    public function close()
    {
//        $this->loadPDF=false;
        $this->emit('printNivelacija');
    }

    public function delete(Dokument $dokument)
    {
        $dokument->stavke()->delete();
        $dokument->delete();
    }

    public function knjizenje(Dokument $dokument)
    {
        $dokument->knjizenje();
    }

    public function rasknjizavanje(Dokument $dokument)
    {
        $dokument->rasknjizavanje();
    }

    public function render()
    {
        $dokID=VrstaDokumenta::where('Sifra','NIV')->first()->id;
        return view('livewire.lista-nivelacija',['nivelacije'=>Dokument::where('Dokument',$dokID)
        ->where(function ($query){
            $query->where('BrDok','like','%'.$this->search.'%')
                ->orWhere('created_at','like','%'.$this->search.'%');
        })->when($this->sortField,function ($query){
            $query->orderBy($this->sortField,$this->sortAsc ? 'asc' : 'desc');
        })->paginate(5)]);
    }
}
