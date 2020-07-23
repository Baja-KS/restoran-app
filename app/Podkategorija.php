<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Podkategorija extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $primaryKey = 'SifKat';
    protected $table='tblPodKategorije';
    public function glavnaKategorija()
    {
        return $this->belongsTo(Kategorija::class,'GlavnaKategorija','SifKat');
    }

    public function artikli()
    {
        return $this->hasMany(Artikal::class,'Kategorija','SifKat');
    }
}
