<?php

namespace App\Http\Livewire;

use App\Dokument;
use App\VrstaDokumenta;
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

    public function delete(Dokument $dokument)
    {
        $dokument->stavke()->delete();
        $dokument->delete();
    }

    public function knjizenje(Dokument $dokument)
    {
        $dokument->knjizenje();
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
