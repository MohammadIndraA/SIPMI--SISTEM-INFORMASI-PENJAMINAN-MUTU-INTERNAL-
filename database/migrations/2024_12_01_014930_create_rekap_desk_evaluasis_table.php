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
        Schema::create('rekap_desk_evaluasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_periode_id')->constrained('tahun_periodes');
            $table->foreignId('lembaga_akreditasi_id')->constrained('lembaga_akreditasis');
            $table->foreignId('target_nilai_mutu_id')->constrained('target_nilai_mutus');
            $table->foreignId('nilai_evaluasi_diri_id')->constrained('evaluasi_diris');
            $table->foreignId('fakultas_prodi_id')->constrained('fakultas_prodis');
            $table->integer('nilai_desk_evaluasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_desk_evaluasis');
    }
};
