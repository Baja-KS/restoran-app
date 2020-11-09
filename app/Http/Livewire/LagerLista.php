<?php

namespace App\Http\Livewire;

use App\Artikal;
use App\Dokument;
use App\DokumentStavka;
use App\Kategorija;
use App\Podkategorija;
use Livewire\Component;
use Livewire\WithPagination;

class LagerLista extends Component
{
    use WithPagination;

    public $search;
    public $sortField;
    public $sortAsc=true;
    public $hrana;
//    public $stavkeDokumenta=null;
    public $artikalKartica=null;


    protected $listeners=['unrenderKartica'=>'ukloniKarticu'];

    public function ukloniKarticu()
    {
        $this->artikalKartica=null;
    }

//    protected $paginationTheme='bootstrap';

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

    public function kartica(Artikal $artikal)
    {
//        $this->stavkeDokumenta=$artikal->stavkeDokument;
        $this->artikalKartica=$artikal;
        $this->emit('renderKartica',$artikal->PLUKod);
        $this->emit('openKartica');
    }



    public function render()
    {
        $idKategorija=collect([]);
        if($this->hrana) {
            $idKategorija = $idKategorija->merge(Kategorija::where('Naziv','Hrana')->first()->podkategorije->pluck('SifKat'));
            $idKategorija = $idKategorija->merge(Podkategorija::where('Naziv', 'Komponente-Hrana')->first()->SifKat);
        }
        else {
            $idGrupe=Kategorija::where('Naziv','Pica')->first()->SifKat;
            $idKategorija = $idKategorija->merge(Podkategorija::where('GlavnaKategorija',$idGrupe)->pluck('SifKat'));
            $idKategorija = $idKategorija->merge(Podkategorija::where('Naziv', 'Komponente-Pica')->first()->SifKat);
        }
        return view('livewire.lager-lista',['artikli'=>Artikal::whereIn('Kategorija',$idKategorija)
            ->where('Normativ',false)
            ->where(function ($query){
            $query->where('PLUKod','like','%'.$this->search.'%')
                ->orWhere('Naziv','like','%'.$this->search.'%');
        })->when($this->sortField,function ($query){
            $query->orderBy($this->sortField,$this->sortAsc ? 'asc' : 'desc');
        })->paginate(5),

        ]);
    }
//'stavkeDokumenta'=>DokumentStavka::join('tblDokumenta','tblDokumenta.id','=','tblDokumentaStavke.IDDOK')
//->join('stpDokumenti','stpDokumenti.id','=','tblDokumenta.Dokument')->paginate(5)
}
