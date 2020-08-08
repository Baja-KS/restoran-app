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

    public function zatvori($nacinPlacanja)
    {
        ZatvorenRacun::create([
            'Sto'=>$this->Sto,
            'Gost'=>$this->Gost,
            'Radnik'=>$this->Radnik,
            'Napomena'=>$this->Napomena,
            'UkupnaCena'=>$this->UkupnaCena,
            'NacinPlacanja'=>$nacinPlacanja
        ]);
        $noviRacun=ZatvorenRacun::where('Sto',$this->Sto)->latest()->first();
        foreach ($this->stavke as $stavka)
        {
            ZatvorenRacunStavka::create([
                'brRacuna'=>$noviRacun->brojRacuna,
                'Artikal'=>$stavka->Artikal,
                'Kolicina'=>$stavka->Kolicina,
                'Popust'=>$stavka->Popust
            ]);
            $stavka->artikal->magacin->prodaj($stavka->Kolicina);
        }
        OtvorenRacun::destroy($this->brojRacuna);
    }

    public function naplati()
    {
        foreach ($this->stavke as $stavka)
            $stavka->artikal->magacin->prodaj($stavka->Kolicina);
        OtvorenRacun::destroy($this->brojRacuna);
    }
}
