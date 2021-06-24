<?php

namespace App\Http\Livewire;

use App\Artikal;
use Livewire\Component;
use Livewire\WithPagination;

class ArtikliTable extends Component
{
    use WithPagination;

    public $search;
    public $sortField;
    public $sortAsc=true;


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


    public function render()
    {
        return view('livewire.artikli-table',[
            'artikli'=>Artikal::join('tblPodKategorije','tblArtikli.Kategorija','=','tblPodKategorije.SifKat')
                ->join('tblKategorije','tblKategorije.SifKat','=','tblPodKategorije.GlavnaKategorija')
                ->select('*','tblArtikli.Naziv as artikalNaziv')
                ->where(function ($query){
                    $query->where('tblArtikli.Naziv','like','%'.$this->search.'%')
                        ->orWhere('tblKategorije.Naziv','like','%'.$this->search.'%')
                        ->orWhere('tblPodKategorije.Naziv','like','%'.$this->search.'%')
                        ->orWhere('tblArtikli.PLUKod','like','%'.$this->search.'%');
                })->when($this->sortField,function ($query){
                    $query->orderBy($this->sortField,$this->sortAsc ? 'asc' : 'desc');
                })->paginate(5)
        ]);
    }
}
