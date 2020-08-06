<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StavkaMagacina extends Model
{
    protected $table='tblMagacinRobe';
    public $timestamps=false;
    protected $guarded=[];

    public function artikal()
    {
        return $this->belongsTo(Artikal::class,'SifraArtikla','PLUKod');
    }

    public function naStanju()
    {
        $artikal = $this->artikal;
        if (!$artikal->Normativ)
        {
            return $this->KolicinaUlaza - $this->KolicinaIzlaza;
        }
        else
        {
            $komponente= $artikal->komponente;
            $sadrzajKomponenta=[];
            foreach ($komponente as $komponenta)
            {
                $naStanjuKomponenta=$komponenta->magacin->naStanju();
                $kolicinaUMesavini=Artikal::kolicinaUMesavini($artikal,$komponenta);
                $sadrzajKomponenta[]=($naStanjuKomponenta/$kolicinaUMesavini);
            }
            return min($sadrzajKomponenta);

        }
    }
}
