<?php

namespace App\Http\Livewire;

use App\Artikal;
use App\DokumentStavka;
use App\VrstaDokumenta;
use Livewire\Component;
use Livewire\WithPagination;

class LagerKarticaArtikla extends Component
{
    use WithPagination;

    public $artikalKartica=null;
    public $searchDok;
    public $sortField;
    public $sortAsc=true;
    public $komponenta=false;

    public function mount(Artikal $artikalKartica)
    {
        $this->artikalKartica=$artikalKartica;
        if($artikalKartica->podkategorija)
        {
            if($artikalKartica->grupa()->Naziv==='Komponente')
                $this->komponenta=true;
            else
                $this->komponenta=false;
        }
    }

    public function updatingSearchDok()
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


    protected $listeners=['renderKartica'=>'azurirajKarticu'];

    public function azurirajKarticu(Artikal $artikal)
    {
        $this->artikalKartica=$artikal;
        if($artikal->podkategorija)
        {
            if($artikal->grupa()->Naziv==='Komponente')
                $this->komponenta=true;
            else
                $this->komponenta=false;
        }
    }

    public function close()
    {
        $this->emit('closeKartica');
        $this->emit('unrenderKartica');
    }


    public function render()
    {
//        dd($this->artikalKartica);
//        if($this->komponenta)
//        {
//            $idNivelacija=VrstaDokumenta::where('Sifra','NIV')->first()->id;
//
//            $idMesavina=$this->artikalKartica->mesavine->pluck('PLUKod');
//            $idMesavina=$idMesavina->merge($this->artikalKartica->PLUKod);
//            $query->whereIn('tblDokumentaStavke.SifraRobe',$idMesavina)
//                ->whereNotIn('tblDokumenta.Dokument',[$idNivelacija]);
//        }
        if($this->komponenta) {
            $mapMesavinaToKolicina=[];

            $idMesavina=$this->artikalKartica->mesavine->pluck('PLUKod');

            foreach ($idMesavina as $idMesavine)
                $mapMesavinaToKolicina[$idMesavine]=Artikal::kolicinaUMesavini(Artikal::find($idMesavine),$this->artikalKartica);

            $idMesavina=$idMesavina->merge($this->artikalKartica->PLUKod);
            $mapMesavinaToKolicina[$this->artikalKartica->PLUKod]=1;
            $idNivelacija=VrstaDokumenta::where('Sifra','NIV')->first()->id;

            return view('livewire.lager-kartica-artikla', [
                'artikalKartica' => $this->artikalKartica,
                'mapMesavinaToKolicina'=>$mapMesavinaToKolicina,
                'stavkeDokumenta' => DokumentStavka::join('tblDokumenta', 'tblDokumenta.id', '=', 'tblDokumentaStavke.IDDOK')
                    ->join('stpDokumenti', 'stpDokumenti.id', '=', 'tblDokumenta.Dokument')
                    ->whereIn('tblDokumentaStavke.SifraRobe', $idMesavina)
                    ->whereNotIn('tblDokumenta.Dokument',[$idNivelacija])
                    ->orderBy('tblDokumenta.created_at', 'desc')
                    ->where(function ($query) {
                        $query->where('tblDokumenta.created_at', 'like', '%' . $this->searchDok . '%');
                    })->when($this->sortField, function ($query) {
                        $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
                    })->paginate(5)
            ]);
        }

        return view('livewire.lager-kartica-artikla',[
            'artikalKartica'=>$this->artikalKartica,
            'stavkeDokumenta'=>DokumentStavka::join('tblDokumenta','tblDokumenta.id','=','tblDokumentaStavke.IDDOK')
            ->join('stpDokumenti','stpDokumenti.id','=','tblDokumenta.Dokument')
                ->where('tblDokumentaStavke.SifraRobe',$this->artikalKartica->PLUKod)
                ->orderBy('tblDokumenta.created_at','desc')
                ->where(function ($query){
                    $query->where('tblDokumenta.created_at','like','%'.$this->searchDok.'%');
                })->when($this->sortField,function ($query){
                    $query->orderBy($this->sortField,$this->sortAsc ? 'asc' : 'desc');
                })->paginate(5)
            ]);
    }
}
