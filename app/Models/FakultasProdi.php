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
    
}
