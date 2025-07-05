<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poin extends Model
{
    protected $table = 'poins';

    protected $guarded = ['id'];

    public function daftar_sub_standar()
    {
        return $this->belongsTo(DaftarSubStandar::class);
    }

        public function prodis()
    {
        return $this->belongsToMany(FakultasProdi::class, 'poin_prodi', 'poin_id', 'fakultas_prodi_id');
    }
}
