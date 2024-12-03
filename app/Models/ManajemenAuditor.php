<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManajemenAuditor extends Model
{
    protected $table = 'manajemen_auditors';
    protected $guarded = ['id'];

    protected $with = ['fakultas_prodis', 'lembaga_akreditasi'];
    /**
     * Relasi Many to Many dengan model FakultasProdi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function fakultas_prodis()
    {
        return $this->belongsToMany(FakultasProdi::class, 'manajemen_auditor_fakultas_prodis', 'manajemen_auditor_id', 'fakultas_prodi_id');
    }

    public function lembaga_akreditasi()
    {
        return $this->belongsTo(LembagaAkreditasi::class);
    }

}
