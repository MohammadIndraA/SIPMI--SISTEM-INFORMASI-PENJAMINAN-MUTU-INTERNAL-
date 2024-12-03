<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetNilaiMutu extends Model
{
    
    protected $table = 'target_nilai_mutus';

    protected $fillable = [
        'tahun_periode_id',
        'fakultas_prodi_id',
        'lembaga_akreditasi_id',
        'target_nilai_mutu',
        'keterangan',
    ];

    protected $with = ['tahun_periode', 'lembaga_akreditasi', 'fakultas_prodi'];

    public function tahun_periode()
    {
        return $this->belongsTo(TahunPeriode::class);
    }

    public function lembaga_akreditasi()
    {
        return $this->belongsTo(LembagaAkreditasi::class);
    }

    public function fakultas_prodi()
    {
        return $this->belongsTo(FakultasProdi::class);
    }
}
