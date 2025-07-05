<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FakultasProdi extends Model
{
    protected $table = 'fakultas_prodis';

    protected $fillable = [
        'fakultas_prodi',
        'status',
    ];
    
    public function poins()
    {
        return $this->belongsToMany(Poin::class, 'poin_prodi', 'fakultas_prodi_id', 'poin_id');
    }
}
