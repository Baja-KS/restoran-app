<?php

namespace App\Http\Livewire;

use App\User;
use Livewire\Component;
use Livewire\WithPagination;

class KorisniciLista extends Component
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



    public function close()
    {
        $this->emit('printNivelacija');
    }

    public function render()
    {
        return view('livewire.korisnici-lista',['korisnici'=>User::where(function ($query){
                $query->where('CompleteName','like','%'.$this->search.'%')
                    ->orWhere('UserID','like','%'.$this->search.'%')
                    ->orWhere('Kasa','like','%'.$this->search.'%')
                    ->orWhere('Objekat','like','%'.$this->search.'%');
            })->when($this->sortField,function ($query){
                $query->orderBy($this->sortField,$this->sortAsc ? 'asc' : 'desc');
            })->paginate(5)]);
    }
}
