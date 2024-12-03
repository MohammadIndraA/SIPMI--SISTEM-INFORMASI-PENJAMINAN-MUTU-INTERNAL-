<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LembagaAkreditasi extends Model
{
    protected $table = 'lembaga_akreditasis';

    protected $fillable = [
        'lembaga_akreditasi',
        'keterangan',
    ];
}
