<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuktiPendukung extends Model
{
    protected $table = 'bukti_pendukungs';

    protected $fillable = [
        'nama',
        'file_pendukung',
        'unit_pengunggah',
        'kategori_dokumen_id',
        'poin_id',
        'daftar_sub_standar_id',
    ];

    public function kategori_dokumen()
    {
        return $this->belongsTo(KategoriDokumen::class);
    }

     public function poin()
    {
        return $this->belongsTo(Poin::class);
    }
}
