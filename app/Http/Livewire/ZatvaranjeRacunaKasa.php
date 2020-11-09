<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ZatvaranjeRacunaKasa extends Component
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
        $this->emit('zDownload','/Restoran/public/'.$fullpath);
    }

    public function zOpen()
    {
        $this->emit('zOpen');
    }

    public function zGotovina()
    {
        $name='zatvgotovina';
        $text='T,1,______,_,__;0;';
        $this->generateFile($name,$text);
    }
    public function zCek()
    {
        $name='zatvcek';
        $text='T,1,______,_,__;2;';
        $this->generateFile($name,$text);
    }

    public function zKartica()
    {
        $name='zatvkartica';
        $text='T,1,______,_,__;1;';
        $this->generateFile($name,$text);
    }

    public function close()
    {
        $this->emit('zClose');
    }

    public function render()
    {
        return view('livewire.zatvaranje-racuna-kasa');
    }
}
