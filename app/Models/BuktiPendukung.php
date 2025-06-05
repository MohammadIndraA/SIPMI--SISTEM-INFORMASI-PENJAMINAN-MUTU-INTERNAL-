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
    ];

    public function kategori_dokumen()
    {
        return $this->belongsTo(KategoriDokumen::class);
    }
}
