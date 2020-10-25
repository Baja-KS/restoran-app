<?php

namespace App\Http\Livewire;

use App\Stampac;
use Livewire\Component;

class PreviewRacun extends Component
{
    public function print()
    {
        if(config('app.print'))
        {
            $stampac=Stampac::firma();
            exec('lp -d ' . $stampac->Naziv . ' -n ' . ' racunfirma.pdf');
        }
        $this->emit('printRacun');
    }

    public function close()
    {
        $this->emit('printRacun');
    }


    public function render()
    {
        return view('livewire.preview-racun');
    }
}
