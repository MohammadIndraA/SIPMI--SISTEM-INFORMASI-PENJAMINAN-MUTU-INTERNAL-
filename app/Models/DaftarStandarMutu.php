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
    
}
