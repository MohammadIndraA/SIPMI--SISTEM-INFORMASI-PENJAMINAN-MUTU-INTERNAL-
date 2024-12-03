<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarNilaiMutu extends Model
{
    protected $table = 'daftar_nilai_mutus';

    protected $fillable = [
        'id',
        'tahun_periode_id',
        'lembaga_akreditasi_id',
        'nilai_mutu',
        'keterangan',
    ];

    protected $with = ['tahun_periode', 'lembaga_akreditasi'];

    public function tahun_periode()
    {
        return $this->belongsTo(TahunPeriode::class);
    }

    public function lembaga_akreditasi()
    {
        return $this->belongsTo(LembagaAkreditasi::class);
    }
}
