<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Artikal extends Model
{
    protected $table='tblArtikli';
    protected $primaryKey='PLUKod';
    protected $guarded=[];
    public $timestamps=true;

    public function podkategorija()
    {
        return $this->belongsTo(Podkategorija::class,'Kategorija','SifKat');
    }

    public function jedinicamere()
    {
        return $this->belongsTo(Jedinicamere::class,'Jedinicamere','JMID');
    }

    public function radnik()
    {
        return $this->belongsTo(User::class,'Radnik','PK');
    }

    public function poreskastopa()
    {
        return $this->belongsTo(PoreskaStopa::class,'PoreskaStopa','Sifra');
    }

    public function magacin()
    {
        return $this->hasOne(StavkaMagacina::class,'SifraArtikla','PLUKod');
    }

    public function PDV()
    {
        return ($this->poreskastopa->vrednost/100)*$this->magacin->ZadnjaProdajnaCena;
    }
    public static function trenutniPLUKod()
    {
        return Artikal::max('PLUKod') ?? 0;
    }

    public static function sledeciPLUKod()
    {
        return self::trenutniPLUKod()+1;
    }

    public function komponente()
    {
        return $this->belongsToMany(Artikal::class,'tblMesavine','ArtikalID','KomponentaID');
    }

    public function mesavine()//mesavine koje sadrze trenutni
    {
        return $this->belongsToMany(Artikal::class,'tblMesavine','KomponentaID','ArtikalID');
    }

    public function sadrzi(Artikal $komponenta)
    {
        return $this->komponente->contains($komponenta);
    }

    public function sadrziSeU(Artikal $mesavina)
    {
        return $this->mesavine->contains($mesavina);
    }

    public static function kolicinaUMesavini(Artikal $mesavina,Artikal $komponenta)
    {
        if ($mesavina->sadrzi($komponenta))
        {
            return DB::table('tblMesavine')
                ->where('ArtikalID',$mesavina->PLUKod)
                ->where('KomponentaID',$komponenta->PLUKod)
                ->pluck('Kolicina')->first();
        }
        return 0;
    }

    public function stavkeRacun()
    {
        return $this->hasMany(OtvorenRacunStavka::class,'Artikal','PLUKod');
    }

}
