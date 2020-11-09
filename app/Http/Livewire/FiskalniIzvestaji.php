<?php

namespace App\Http\Livewire;

use App\Dokument;
use App\VrstaDokumenta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class FiskalniIzvestaji extends Component
{
    private function generateFile($name,$text)
    {
        $path='storage/';
        $ext='.inp';
        $fullpath=$path.$name.$ext;
        $file=fopen($fullpath,'w');
        fwrite($file,$text);
        fclose($file);
//        return Storage::disk('public')->download($name.$ext);
//        return response()->download(storage_path('app/public/'.$name.$ext));
        $this->emit('downloadIzvestaj',$fullpath);
    }

    public $od;
    public $do;

    public function openKnjigaSanka()
    {
        $this->emit('openKnjigaSanka');
    }

    public function zatvoriDan()
    {
        $idRacun=VrstaDokumenta::where('Sifra','RCM')->first()->id;
        if(!Carbon::now()->between(Carbon::today()->startOfDay(),Carbon::today()->startOfDay()->addHours(5)))
            return;
        $racuni=Dokument::where('Dokument',$idRacun)
            ->whereBetween('created_at',[Carbon::today()->startOfDay(),
                Carbon::today()->startOfDay()->addHours(5)]);
        $racuni->update([
            'created_at'=>Carbon::yesterday()->startOfDay()->addHours(23)->addMinutes(59),
            'updated_at'=>Carbon::yesterday()->startOfDay()->addHours(23)->addMinutes(59),
        ]);

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
