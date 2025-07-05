<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarTemuanAudit extends Model
{
    protected $table = 'daftar_temuan_audits';
    protected $guarded = [];

    public function daftar_sub_standar()
    {
        return $this->belongsTo(DaftarSubStandar::class);
    }

    public function poin()
    {
        return $this->belongsTo(Poin::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
