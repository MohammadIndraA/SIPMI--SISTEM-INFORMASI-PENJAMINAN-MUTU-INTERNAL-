<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanPeriode extends Model
{
    protected $table = 'pengaturan_periodes';

    protected $with = ['tahun_periode', 'lembaga_akreditasi', 'standar_nasionals'];

    protected $fillable = [
        'tahun_periode_id', 'lembaga_akreditasi_id', 'awal_periode_evaluasi_diri', 'akhir_periode_evaluasi_diri', 'awal_periode_desk_evaluasi', 'akhir_periode_desk_evaluasi', 'awal_periode_visitasi', 'akhir_periode_visitasi',   
    ];

    public function standar_nasionals()
    {
        return $this->belongsToMany(StandarNasional::class , 'pengaturan_periode_standar_nasionals');
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
