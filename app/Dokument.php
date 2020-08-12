<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dokument extends Model
{
    protected $table='tblDokumenta';
    protected $guarded=[];

    public function stavke()
    {
        return $this->hasMany(DokumentStavka::class,'IDDOK','id');
    }

    public function vrstaDokumenta()
    {
        return $this->belongsTo(VrstaDokumenta::class,'Dokument','id');
    }

    public function komitent()
    {
        return $this->belongsTo(Komitent::class,'SifKom','Sifra');
    }

    public function orgJedinica()
    {
        return $this->belongsTo(OrganizacionaJedinica::class,'SifOj2','SifOj');
    }

    public function radnik()
    {
        return $this->belongsTo(User::class,'Radnik','PK');
    }
    public static function brDok(VrstaDokumenta $vrstaDokumenta)
    {
        return $vrstaDokumenta->dokumenti->count() ?? 0;
    }
    public static function sledeciBrDok(VrstaDokumenta $vrstaDokumenta)
    {
        return self::brDok($vrstaDokumenta)+1;
    }
    public static function brVezanogDok()
    {
        return self::max('BrVezanogDok') ?? 0;
    }
    public static function sledeciBrVezanogDok()
    {
        return self::brVezanogDok()+1;
    }

    public function profit()
    {
        $profit=0;
        foreach ($this->stavke as $stavka)
            $profit+=$stavka->profit();
        return $profit;
    }

}
