<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    protected $table = 'jawabans';

    protected $fillable = [
        'user_id',
        'daftar_sub_standar_id',
        'poin_id',
        'jawaban',
        'catatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function poin()
    {
        return $this->belongsTo(Poin::class);
    }

    public function daftar_sub_standar()
    {
        return $this->belongsTo(DaftarSubStandar::class);
    }

    
}
