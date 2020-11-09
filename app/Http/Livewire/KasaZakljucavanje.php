<?php

namespace App\Http\Livewire;

use App\OtvorenRacun;
use App\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class KasaZakljucavanje extends Component
{
    public $konobarZaSto=[];

    public function mount()
    {
        for ($i=1;$i<=config('app.brojStolova');$i++)
            if(OtvorenRacun::where('Sto',$i)->count())
                $this->konobarZaSto[$i]=OtvorenRacun::where('Sto',$i)->first()->Radnik;
    }

    public function potvrdiIzmene()
    {
        $this->emit('potvrdiIzmene');
    }

    public function sacuvajIzmene()
    {
        foreach ($this->konobarZaSto as $sto=>$konobar)
        {
            OtvorenRacun::where('Sto',$sto)->update([
                'Radnik'=>$konobar
            ]);
        }
        $this->close();
    }

    public function close()
    {
        $this->emit('cancelIzmene');
    }

    public function render()
    {
        return view('livewire.kasa-zakljucavanje',['radnici'=>User::all()]);
    }
}
