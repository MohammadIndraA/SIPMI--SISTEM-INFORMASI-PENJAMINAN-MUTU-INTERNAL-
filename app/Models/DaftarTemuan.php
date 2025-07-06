<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarTemuan extends Model
{
    protected $table = 'daftar_temuans';

    protected $fillable = [
        'fakultas_prodi_id',
        'tahun_periode_id',
        'lembaga_akreditasi_id',
        'poin_id',
        'user_id',
        'jumlah_temuan',
        'jumlah_temuan_disetujui',
    ];
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

    public function poin()
    {
        return $this->belongsTo(Poin::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
