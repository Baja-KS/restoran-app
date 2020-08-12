<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OtvorenRacun extends Model
{
    protected $table='tblOtvoreniRacuni';
    protected $primaryKey='brojRacuna';
    protected $guarded=[];

    public function stavke()
    {
        return $this->hasMany(OtvorenRacunStavka::class,'brRacuna','brojRacuna');
    }

    public function gost()
    {
        return $this->belongsTo(Komitent::class,'Gost','Sifra');
    }

    public function radnik()
    {
        return $this->belongsTo(User::class,'Radnik','PK');
    }
    public static function racuniZaSto($sto)
    {
        return OtvorenRacun::where('Sto',$sto);
    }
    public static function brojRacunaZaSto($sto)
    {
        return self::racuniZaSto($sto)->count();
    }
    public static function ukupnoZaSto($sto)
    {
        return self::racuniZaSto($sto)->sum('UkupnaCena');
    }

    public function UkupnaCena()
    {
        $ukupno=0;
        foreach ($this->stavke as $stavka)
        {
            $ukupno+=$stavka->cenaSaPopustom();
        }
        return $ukupno;
    }
    public function zaSank()
    {
        $zaSank=collect([]);
        foreach ($this->stavke as $stavka)
        {
            if ($stavka->artikal->podkategorija->glavnaKategorija->Naziv=='Pica')
            {
                $zaSank->push($stavka);
            }
        }
        return $zaSank;
    }

    public function zaKuhinju()
    {
        $zaKuhinju=collect([]);
        foreach ($this->stavke as $stavka)
        {
            if ($stavka->artikal->podkategorija->glavnaKategorija->Naziv=='Hrana')
            {
               $zaKuhinju->push($stavka);
            }
        }
        return $zaKuhinju;
    }

    public function zatvori($nacinPlacanja,$placeno)
    {
//        ZatvorenRacun::create([
//            'Sto'=>$this->Sto,
//            'Gost'=>$this->Gost,
//            'Radnik'=>$this->Radnik,
//            'Napomena'=>$this->Napomena,
//            'UkupnaCena'=>$this->UkupnaCena,
//            'NacinPlacanja'=>$nacinPlacanja
//        ]);
//        $noviRacun=ZatvorenRacun::where('Sto',$this->Sto)->latest()->first();
//        foreach ($this->stavke as $stavka)
//        {
//            ZatvorenRacunStavka::create([
//                'brRacuna'=>$noviRacun->brojRacuna,
//                'Artikal'=>$stavka->Artikal,
//                'Kolicina'=>$stavka->Kolicina,
//                'Popust'=>$stavka->Popust
//            ]);
//            $stavka->artikal->magacin->prodaj($stavka->Kolicina);
//        }
//        OtvorenRacun::destroy($this->brojRacuna);
        $this->naplati($nacinPlacanja,$placeno,true);
    }

    public function naplati($nacinPlacanja,$placeno,$zatvoren=false,$brFiskal=null)
    {
        $vrsta=VrstaDokumenta::where('Sifra','RCM')->first();
        $orgjed=OrganizacionaJedinica::where('Vrsta','R')->first();
        Dokument::create([
            'Dokument'=>$vrsta->id,
            'BrDok'=>Dokument::sledeciBrDok($vrsta),
            'BrVezanogDok'=>Dokument::sledeciBrVezanogDok(),
            'SifKom'=>$this->Gost,
            'SifOj1'=>auth()->user()->Objekat,
            'SifOj2'=>$orgjed->SifOj,
            'Napomena'=>$this->Napomena,
            'VrstaDok'=>$zatvoren ? 'z' :'p',
            $nacinPlacanja=>$this->UkupnaCena,
            'BrFiskal'=>$brFiskal,
            'Radnik'=>$this->Radnik,
            'DatumF'=>date("Y-m-d"),
            'VremeF'=>date("H:i"),
            'Ukupno1'=>$this->UkupnaCena,
            'BrojStola'=>$this->Sto,
            'Placeno'=>$placeno,
            'Dan'=>(new \DateTime(Firma::first()->created_at))->diff(new \DateTime(date("Y-m-d H:i:s")))->days
        ]);
        $noviRacun=Dokument::all()->last();
        foreach ($this->stavke as $stavka) {
            DokumentStavka::create([
                'IDDOK'=>$noviRacun->id,
                'SifraRobe'=>$stavka->Artikal,
                'Kolicina'=>$stavka->Kolicina,
                'Rabat'=>0,
                'NabCena'=>$stavka->artikal->magacin->ZadnjaNabavnaCena,
                'ProdCena'=>$stavka->cenaSaPopustom(),
                'Odstampano'=>!$zatvoren
            ]);
            $stavka->artikal->magacin->prodaj($stavka->Kolicina);
        }
        OtvorenRacun::destroy($this->brojRacuna);
    }
}
