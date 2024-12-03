<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunPeriode extends Model
{
    protected $table = 'tahun_periodes';

    protected $fillable = [
        'tahun_periode',
        'status',
    ];
}
