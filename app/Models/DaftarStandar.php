<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarStandar extends Model
{
    protected $table = 'daftar_standars';

    protected $guarded = ['id'];

    public function daftar_standar_mutu()
    {
        return $this->belongsTo(DaftarStandarMutu::class, 'daftar_standar_mutu_id');
    }

    public function daftar_sub_standars()
    {
        return $this->hasMany(DaftarSubStandar::class, 'daftar_standar_id', 'id');
    }
}
