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
}
