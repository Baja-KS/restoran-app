<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;

class FiskalniIzvestaji extends Component
{
    private function generateFile($name,$text)
    {
        $path=config('app.homeDir').'fplink/input/';
        $ext='.inp';
        $fullpath=$path.$name.$ext;
        $file=fopen($fullpath,'w');
        fwrite($file,$text);
        fclose($file);
    }

    public $od;
    public $do;

    public function openKnjigaSanka()
    {
        $this->emit('openKnjigaSanka');
    }

    public function zatvoriDan()
    {
        //TODO
    }

    public function prodatiArtikli()
    {
        $name='prodati';
        $text='111,1,______,_,__;0;1;1;100;';
        $this->generateFile($name,$text);
    }

    public function presekStanja()
    {
        $name='presek';
        $text='X,1,______,_,__;';
        $this->generateFile($name,$text);
    }

    public function dnevniIzvestaj()
    {
        $this->emit('dnevniIzvestaj');
    }

    public function openPeriodicni()
    {
        $this->emit('periodicniIzvestaj');
    }

    public function periodicniIzvestaj()
    {
        $datumOd=Carbon::createFromFormat('Y-m-d',$this->od);
        $datumDo=Carbon::createFromFormat('Y-m-d',$this->do);

        $stringOd=$datumOd->format('mdy');
        $stringDo=$datumDo->format('mdy');

        $name='periodicni';
        $text="79,1,______,_,__;".$stringOd.";".$stringDo.";";
        $this->generateFile($name,$text);
        $this->closePeriodicni();
    }

    public function confirmDnevni()
    {
        $name='dnevni';
        $text='Z,1,______,_,__;';
        $this->generateFile($name,$text);
//        $this->emit('confirmDnevni');
//        $this->closeDnevni();
        $this->closeDnevni();
    }

    public function cancelDnevni()
    {
        $this->emit('cancelDnevni');
    }

    public function closePeriodicni()
    {
        $this->emit('closePeriodicni');
    }

    public function close()
    {
        $this->emit('closeFI');
    }

    public function closeDnevni()
    {
        $this->emit('cancelDnevni');
    }

    public function render()
    {
        return view('livewire.fiskalni-izvestaji');
    }
}
