<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RencanaTindakLanjut extends Model
{
    protected $table = 'rencana_tindak_lanjuts';

    protected $guarded = ['id'];

    public function poin()
    {
        return $this->belongsTo(Poin::class);
    }
}
