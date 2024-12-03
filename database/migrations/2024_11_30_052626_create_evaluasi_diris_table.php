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
        Schema::create('evaluasi_diris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lembaga_akreditasi_id')->constrained('lembaga_akreditasis');
            $table->foreignId('fakultas_prodi_id')->constrained('fakultas_prodis');
            $table->string('target_nilai_mutu');
            $table->string('nilai_evaluasi')->default(0);
            $table->string('sudah_menjawab')->default(0);
            $table->string('belum_menjawab')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluasi_diris');
    }
};
