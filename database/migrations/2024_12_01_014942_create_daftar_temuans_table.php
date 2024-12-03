<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('daftar_temuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_periode_id')->constrained('tahun_periodes');
            $table->foreignId('lembaga_akreditasi_id')->constrained('lembaga_akreditasis');
            $table->foreignId('fakultas_prodi_id')->constrained('fakultas_prodis');
            $table->string('jumlah_temuan')->default('tidak ada temuan');
            $table->string('jumlah_temuan_disetujui')->default('tidak ada temuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_temuans');
    }
};
