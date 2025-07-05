<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarStandarMutu extends Model
{
    protected $table = 'daftar_standar_mutus';

    protected $fillable = [
        'tahun_periode_id',
        'lembaga_akreditasi_id',
        'nama_standar_mutu',
        'deskripsi',
    ];
    
    public function daftar_standars()
    {
        return $this->hasMany(DaftarStandar::class, 'daftar_standar_mutu_id');
    }

    public function daftar_sub_standars()
    {
        return $this->hasMany(DaftarSubStandar::class, 'daftar_standar_mutu_id');
    }

    
    public function tahun_periode()
    {
        return $this->belongsTo(TahunPeriode::class);
    }

    public function lembaga_akreditasi()
    {
        return $this->belongsTo(LembagaAkreditasi::class);
    }
}
