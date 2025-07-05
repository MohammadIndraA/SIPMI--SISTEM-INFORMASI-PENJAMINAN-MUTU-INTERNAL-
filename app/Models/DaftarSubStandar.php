<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarSubStandar extends Model
{
    protected $guarded = ['id'];
   
    public function daftar_standar_mutu()
    {
        return $this->belongsTo(DaftarStandarMutu::class, 'daftar_standar_mutu_id', 'id');
    }

    // Relasi ke DaftarStandar
    public function daftar_standar()
    {
        return $this->belongsTo(DaftarStandar::class, 'daftar_standar_id', 'id');
    }

    public function poins()
    {
        return $this->hasMany(Poin::class,'daftar_sub_standar_id');
    }

}
