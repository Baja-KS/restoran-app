<?php

namespace App\Http\Livewire;

use App\Artikal;
use App\Dokument;
use App\DokumentStavka;
use App\Firma;
use App\Kategorija;
use App\OrganizacionaJedinica;
use App\VrstaDokumenta;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class FormNivelacija extends Component
{
    public $razlikaUCeniUkupno=0;
    public $vrednostPDVUkupno=0;
    public $edit;
    public $nivelacija;
    public $rowCount=1;
    public $napomena;
    public $brNivelacije;
    public $datumNivelacije;

    public $sifra=[""];
    public $jm=[""];
    public $kolicina=[0];
    public $pdv=[0];
    public $zadnjaProdajnaCena=[0];
    public $novaProdajnaCena=[0];
    public $razlikaUCeni=[0];
    public $vrednostPDV=[0];

    public function resetForm()
    {
        $this->razlikaUCeniUkupno=0;
        $this->vrednostPDVUkupno=0;
        $this->rowCount=1;
        $this->napomena="";

        $this->sifra=[""];
        $this->jm=[""];
        $this->kolicina=[0];
        $this->pdv=[0];
        $this->zadnjaProdajnaCena=[0];
        $this->novaProdajnaCena=[0];
        $this->razlikaUCeni=[0];
        $this->vrednostPDV=[0];
    }

    public function mount(Dokument $dokument)
    {
        if($this->edit)
        {
            $this->nivelacija=$dokument;
//            $this->rowCount=$dokument->stavke->count();
            $this->napomena=$dokument->Napomena;
            $this->rowCount=0;
            for ($i=0;$i<$dokument->stavke->count();$i++)
                $this->incRowCount();
//            dd($dokument->Dokument);
            foreach ($dokument->stavke as $index=>$stavka)
            {
                $this->sifra[$index]=$stavka->SifraRobe;
                $this->jm[$index]=$stavka->artikal->jedinicamere->Naziv;
                $this->kolicina[$index]=$stavka->artikal->magacin->naStanju();
                $this->pdv[$index]=$stavka->artikal->poreskastopa->Vrednost;
                $this->zadnjaProdajnaCena[$index]=$stavka->StaraProdajnaCena;
                $this->novaProdajnaCena[$index]=$stavka->ProdCena;
                $this->razlikaUCeni[$index]=($this->zadnjaProdajnaCena[$index]-$this->novaProdajnaCena[$index])*$stavka->Kolicina;
                $this->vrednostPDV[$index]=($this->razlikaUCeni[$index])-($this->razlikaUCeni[$index]/(1+$this->pdv[$index]));
                $this->vrednostPDVUkupno+=$this->vrednostPDV[$index];
                $this->razlikaUCeniUkupno+=$this->razlikaUCeni[$index];
            }
        }
    }

    public function updated()
    {
        $zbirPdv=0;
        $zbirRazlika=0;
        for ($i=0;$i<$this->rowCount;$i++)
        {
//            dd($this->sifra[$i]);
            $artikal=Artikal::where('PLUKod',$this->sifra[$i])->first();
            $this->kolicina[$i]=$artikal->magacin->naStanju();
            $this->jm[$i]=$artikal->jedinicamere->Naziv;
            $this->pdv[$i]=$artikal->poreskastopa->Vrednost;
            $this->zadnjaProdajnaCena[$i]=$artikal->magacin->ZadnjaProdajnaCena;
            $this->razlikaUCeni[$i]=round(($this->zadnjaProdajnaCena[$i]-($this->novaProdajnaCena[$i]==="" ? 0 : $this->novaProdajnaCena[$i]))*($this->kolicina[$i]),2);
            $this->vrednostPDV[$i]=round(($this->razlikaUCeni[$i])-($this->razlikaUCeni[$i]/(1+$this->pdv[$i])),2);
            $zbirPdv+=$this->vrednostPDV[$i];
            $zbirRazlika+=$this->razlikaUCeni[$i];
        }
        $this->razlikaUCeniUkupno=round($zbirRazlika,2);
        $this->vrednostPDVUkupno=round($zbirPdv,2);
    }

    public function incRowCount()
    {
        $this->sifra[]="";
        $this->jm[]="";
        $this->kolicina[]=0;
        $this->pdv[]=0;
        $this->zadnjaProdajnaCena[]=0;
        $this->novaProdajnaCena[]=0;
        $this->razlikaUCeni[]=0;
        $this->vrednostPDV[]=0;
        $this->rowCount++;
    }

    public function decRowCount($index)
    {

        array_splice($this->sifra,$index,1);
        array_splice($this->jm,$index,1);
        array_splice($this->kolicina,$index,1);
        array_splice($this->pdv,$index,1);
        array_splice($this->zadnjaProdajnaCena,$index,1);
        array_splice($this->novaProdajnaCena,$index,1);
        array_splice($this->razlikaUCeni,$index,1);
        array_splice($this->vrednostPDV,$index,1);

        $this->rowCount--;
    }


    public function create()
    {
        $idVrsteDok=VrstaDokumenta::where('Sifra','NIV')->first()->id;
        $idOrgJed=OrganizacionaJedinica::where('Vrsta','R')->first()->SifOj;
        Dokument::create([
            'Dokument'=>$idVrsteDok,
            'BrDok'=>Dokument::sledeciBrDok(VrstaDokumenta::where('Sifra','NIV')->first()),
            'BrVezanogDok'=>Dokument::sledeciBrVezanogDok(),
            'SifOj1'=>auth()->user()->Objekat,
            'SifOj2'=>$idOrgJed,
            'Napomena'=>$this->napomena,
            'Dan'=>(new \DateTime(Firma::first()->created_at))->diff(new \DateTime(date("Y-m-d H:i:s")))->days,
            'DatumF'=>date("Y-m-d"),
            'VremeF'=>date("H:i"),
            'Radnik'=>auth()->user()->PK,
            'BrojStola'=>0,
            'Ukupno1'=>0,
            'Placeno'=>0
        ]);
        $idDok=Dokument::all()->last()->id;
        for ($i=0;$i<$this->rowCount;$i++)
        {
            DokumentStavka::create([
                'IDDOK'=>$idDok,
                'SifraRobe'=>$this->sifra[$i],
                'Kolicina'=>$this->kolicina[$i],
                'NabCena'=>0,
                'Rabat'=>0,
                'ProdCena'=>$this->novaProdajnaCena[$i],
                'StaraProdajnaCena'=>Artikal::find($this->sifra[$i])->magacin->ZadnjaProdajnaCena,
                'Odstampano'=>false
            ]);
        }
        $this->resetForm();
        return Redirect::route('listaNivelacije');

    }

    public function update(Dokument $dokument)
    {
        if ($dokument->IndikatorKnjizenja)
            return Redirect::route('indexPrijemnica');
        $dokument->update([
            'Napomena'=>$this->napomena,
        ]);
        DokumentStavka::destroy($dokument->stavke->pluck('id'));
        $size=$this->rowCount;
        for ($i=0;$i<$size;$i++)
        {
            DokumentStavka::create([
                'IDDOK'=>$dokument->id,
                'SifraRobe'=>$this->sifra[$i],
                'Kolicina'=>$this->kolicina[$i],
                'NabCena'=>0,
                'Rabat'=>0,
                'ProdCena'=>$this->novaProdajnaCena[$i],
                'StaraProdajnaCena'=>Artikal::find($this->sifra[$i])->magacin->ZadnjaProdajnaCena,
                'Odstampano'=>false
            ]);
        }
        $this->resetForm();
        return Redirect::route('listaNivelacije');
    }

    public function render()
    {
        $idKomponenti=Kategorija::where('Naziv','Komponente')->first()->podkategorije->pluck('SifKat');
        return view('livewire.form-nivelacija',['artikli'=>Artikal::whereNotIn('Kategorija',$idKomponenti)->get()]);
    }
}
