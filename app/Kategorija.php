<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategorija extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $primaryKey = 'SifKat';
    protected $table='tblKategorije';
    public function podkategorije()
    {
        return $this->hasMany(Podkategorija::class,'GlavnaKategorija','SifKat');
    }

    public function artikli()
    {
        $artikli=collect([]);
//        collect($artikli);
        foreach ($this->podkategorije as $podkategorija)
        {
            $artikli=$artikli->concat($podkategorija->artikli);
        }
        return $artikli;
    }

}
