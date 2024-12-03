<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManajemenDokumen extends Model
{
    protected $table = 'manajemen_dokumens';

    protected $guarded = ['id'];

    protected $with = ['kategori_dokumen'];
    public function kategori_dokumen()
    {
        return $this->belongsTo(KategoriDokumen::class);
    }
}
