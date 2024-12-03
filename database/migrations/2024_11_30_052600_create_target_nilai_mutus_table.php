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
        Schema::create('target_nilai_mutus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fakultas_prodi_id')->constrained('fakultas_prodis');
            $table->foreignId('tahun_periode_id')->constrained('tahun_periodes');
            $table->foreignId('lembaga_akreditasi_id')->constrained('lembaga_akreditasis');
            $table->string('target_nilai_mutu');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_nilai_mutus');
    }
};
