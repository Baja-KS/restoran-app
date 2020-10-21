<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DokumentStavka extends Model
{
    protected $table='tblDokumentaStavke';
    protected $guarded=[];
    public $timestamps=false;

    public function dokument()
    {
        return $this->belongsTo(Dokument::class,'IDDOK','id');
    }

    public function artikal()
    {
        return $this->belongsTo(Artikal::class,'SifraRobe','PLUKod');
    }

    public function popust()
    {

        $saPopustom=$this->ProdCena;
        $bezPopusta=$this->artikal->magacin->ZadnjaProdajnaCena;
        if ($bezPopusta==0)
            return 0;
        return( 100*($bezPopusta-$saPopustom))/$bezPopusta;
    }

    public function profit()
    {
        if (!$this->artikal->Normativ)
            return $this->Kolicina*($this->ProdCena-$this->artikal->magacin->ZadnjaNabavnaCena);
        else
        {
            $nabavnaCena=0;
            foreach ($this->artikal->komponente as $komponenta)
            {
                $kolicina=Artikal::kolicinaUMesavini($this->artikal,$komponenta);
                $nabavnaCena+=$kolicina*$komponenta->magacin->ZadnjaNabavnaCena;
            }
            return $this->Kolicina*($this->ProdCena-$nabavnaCena);
        }
    }

    public function razlikaUCeni()
    {
        return ($this->StaraProdajnaCena-$this->ProdCena)*$this->Kolicina;
    }

    public function vrednostPDVpoRazlici()
    {
        return ($this->razlikaUCeni())-($this->razlikaUCeni()/(1+$this->artikal->poreskastopa->Vrednost));
    }

    public function knjizenje()
    {
        $magacin=StavkaMagacina::where('SifraArtikla',$this->SifraRobe)->first();
        if ($this->dokument->vrstaDokumenta->Sifra==='KLM')
        {
            $ulaz=$magacin->KolicinaUlaza;
            $magacin->update([
                'KolicinaUlaza'=>$ulaz+$this->Kolicina,
                'ZadnjaNabavnaCena'=>$this->NabCena
            ]);
        }
        else if($this->dokument->vrstaDokumenta->Sifra==='NIV')
        {
            $staraProdajna=$magacin->ZadnjaProdajnaCena;
            $magacin->update([
                'ZadnjaProdajnaCena'=>$this->ProdCena
            ]);
            $this->update([
                'StaraProdajnaCena'=>$staraProdajna
            ]);
        }
    }
    public function rasknjizavanje()
    {
        $magacin=StavkaMagacina::where('SifraArtikla',$this->SifraRobe)->first();
        if ($this->dokument->vrstaDokumenta->Sifra==='KLM')
        {
            //TODO
        }
        else if($this->dokument->vrstaDokumenta->Sifra==='NIV')
        {
            $magacin->update([
                'ZadnjaProdajnaCena'=>$this->StaraProdajnaCena
            ]);
        }
    }
}
