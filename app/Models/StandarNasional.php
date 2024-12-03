<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StandarNasional extends Model
{
    protected $table = 'standar_nasionals';

    protected $fillable = [
        'standar_nasional',
        'keterangan',
    ];
}
