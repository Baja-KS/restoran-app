<?php

namespace App\Http\Livewire;

use App\Artikal;
use App\DokumentStavka;
use Livewire\Component;
use Livewire\WithPagination;

class LagerKarticaArtikla extends Component
{
    use WithPagination;

    public $artikalKartica=null;
    public $searchDok;
    public $sortField;
    public $sortAsc=true;

    public function mount(Artikal $artikalKartica)
    {
        $this->artikalKartica=$artikalKartica;
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
    }

    public function close()
    {
        $this->emit('closeKartica');
        $this->emit('unrenderKartica');
    }


    public function render()
    {
//        dd($this->artikalKartica);
        return view('livewire.lager-kartica-artikla',[
            'artikalKartica'=>$this->artikalKartica,
            'stavkeDokumenta'=>DokumentStavka::join('tblDokumenta','tblDokumenta.id','=','tblDokumentaStavke.IDDOK')
            ->join('stpDokumenti','stpDokumenti.id','=','tblDokumenta.Dokument')
                ->where('tblDokumentaStavke.SifraRobe',$this->artikalKartica->PLUKod)
                ->orderBy('tblDokumenta.created_at','desc')
                ->where(function ($query){
//                    $query->where('stpDokumenti.Opis','like','%'.$this->searchDok.'%')
//                        $query->where('tblDokumenta.BrDok','like','%'.$this->searchDok.'%')
//                        ->orWhere('tblDokumenta.created_at','like','%'.$this->searchDok.'%')
//                        ->orWhere('tblDokumentaStavke.Kolicina','like','%'.$this->searchDok.'%')
//                        ->orWhere('tblDokumentaStavke.NabCena','like','%'.$this->searchDok.'%')
//                        ->orWhere('tblDokumentaStavke.ProdCena','like','%'.$this->searchDok.'%');
                    $query->where('tblDokumenta.created_at','like','%'.$this->searchDok.'%');
                })->when($this->sortField,function ($query){
                    $query->orderBy($this->sortField,$this->sortAsc ? 'asc' : 'desc');
                })->paginate(5)
            ]);
    }
}
