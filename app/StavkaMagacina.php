<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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
            if (count($sadrzajKomponenta)==0)
                return $this->KolicinaUlaza - $this->KolicinaIzlaza;
            return min($sadrzajKomponenta);

        }
    }

    public function prodatoNaCrno()
    {
        $idDokRacun=VrstaDokumenta::where('Sifra','RCM')->first()->id;
        $artikal=$this->artikal;
        $prodatoNaCrno=0;
        if($artikal->grupa()->Naziv!='Komponente')
        {
            foreach ($artikal->stavkeDokument as $stavka)
            {
                if($stavka->dokument->VrstaDok==='z')
                    $prodatoNaCrno+=$stavka->Kolicina;
            }
        }
        else
        {
            $stavkeDokumenta=collect([]);
            foreach ($artikal->mesavine as $mesavina)
                $stavkeDokumenta=$stavkeDokumenta->merge($mesavina->stavkeDokument);
            foreach ($stavkeDokumenta as $stavka)
            {
                if($stavka->dokument->VrstaDok==='z')
                    $prodatoNaCrno+=$stavka->Kolicina*Artikal::kolicinaUMesavini($artikal,$stavka->artikal);
            }
        }
        return $prodatoNaCrno;

    }

    public function prenetaKolicinaDatuma($datum,$naCrnoUracunato=false)
    {
        $idDokRacun=VrstaDokumenta::where('Sifra','RCM')->first()->id;
        $idDokPrijemnica=VrstaDokumenta::where('Sifra','KLM')->first()->id;


        $artikal=$this->artikal;

        $ulazPosleDatuma=0;
        $izlazPosleDatuma=0;

        $datum=Carbon::createFromFormat('Y-m-d',$datum)->startOfDay();

        if($artikal->grupa()->Naziv!='Komponente')
        {
            foreach ($artikal->stavkeDokument as $stavka)
            {
                $datumDok=$stavka->dokument->created_at->startOfDay();
//                dd($stavka->dokument->created_at,$datum);
                if($datum->lte($datumDok))
                {
                    if($stavka->dokument->Dokument===$idDokRacun && ($naCrnoUracunato || $stavka->dokument->VrstaDok!='z')) {
                        $izlazPosleDatuma += $stavka->Kolicina;
//                        Log::info($datumDok->format('Y-m-d')." Za ".$datum->format('Y-m-d')."Izlaz:".$stavka->Kolicina);
                    }
                    elseif ($stavka->dokument->Dokument===$idDokPrijemnica) {
                        $ulazPosleDatuma += $stavka->Kolicina;
//                        Log::info($datumDok->format('Y-m-d')." Za ".$datum->format('Y-m-d')."Ulaz:".$stavka->Kolicina);
                    }


                }
            }
            $prodatoNaCrno=0;
            $naCrnoUracunato ? $prodatoNaCrno=0 : $prodatoNaCrno=$this->prodatoNaCrno();
            return $this->naStanju()+$prodatoNaCrno+$izlazPosleDatuma-$ulazPosleDatuma;
        }
        else
        {
            $stavkeDokumenta=collect([]);//ovde idu sve mesavine koji sadrze $artikal koji je komponenta
            foreach ($artikal->mesavine as $mesavina)
                $stavkeDokumenta=$stavkeDokumenta->merge($mesavina->stavkeDokument);
            Log::info($stavkeDokumenta);
            foreach ($stavkeDokumenta as $stavka)
            {
                $datumDok=$stavka->dokument->created_at->startOfDay();
                if($datum->lte($datumDok))
                {
                    if($stavka->dokument->Dokument===$idDokRacun && ($naCrnoUracunato || $stavka->dokument->VrstaDok!='z')) {
                        $izlazPosleDatuma += $stavka->Kolicina*Artikal::kolicinaUMesavini($stavka->artikal,$artikal);
//                        Log::info("Kolicina mesavine:".$stavka->Kolicina." Kolicina komponente u mesavini: ".Artikal::kolicinaUMesavini($stavka->artikal,$artikal));
                    }
                }
            }
            foreach ($artikal->stavkeDokument as $stavka)
            {
                $datumDok=$stavka->dokument->created_at->startOfDay();
//                dd($stavka->dokument->created_at,$datum);
                if($datum->lte($datumDok))
                {
                    if ($stavka->dokument->Dokument===$idDokPrijemnica) {
                        $ulazPosleDatuma += $stavka->Kolicina;
//                        Log::info($datumDok->format('Y-m-d')." Za ".$datum->format('Y-m-d')."Ulaz:".$stavka->Kolicina);
                    }
                }
            }
            $prodatoNaCrno=0;
            $naCrnoUracunato ? $prodatoNaCrno=0 : $prodatoNaCrno=$this->prodatoNaCrno();
            return $this->naStanju()+$prodatoNaCrno+$izlazPosleDatuma-$ulazPosleDatuma;
        }
        return 0;
    }

    public function prodaj($kolicina)
    {
        $artikal=$this->artikal;
        if (!$artikal->Normativ)
        {
            $this->increment('KolicinaIzlaza',$kolicina);
        }
        else
        {
            $komponente=$artikal->komponente;
            foreach ($komponente as $komponenta)
            {
                $kolicinaUMesavini=Artikal::kolicinaUMesavini($artikal,$komponenta);
                $komponenta->magacin->increment('KolicinaIzlaza',($kolicina*$kolicinaUMesavini));
            }
        }
    }
}
