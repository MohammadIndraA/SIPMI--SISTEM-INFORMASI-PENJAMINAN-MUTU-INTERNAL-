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
        Schema::create('pengaturan_periodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_periode_id')->constrained('tahun_periodes');
            $table->foreignId('lembaga_akreditasi_id')->constrained('lembaga_akreditasis');
            $table->date('awal_periode_evaluasi_diri');
            $table->date('akhir_periode_evaluasi_diri');
            $table->date('awal_periode_desk_evaluasi');
            $table->date('akhir_periode_desk_evaluasi');
            $table->date('awal_periode_visitasi');
            $table->date('akhir_periode_visitasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan_periodes');
    }
};
