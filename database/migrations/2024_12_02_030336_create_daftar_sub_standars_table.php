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
        Schema::create('daftar_sub_standars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daftar_standar_mutu_id')->constrained('daftar_standar_mutus');
            $table->foreignId('daftar_standar_id')->constrained('daftar_standars');
            $table->string('nama_sub_standar');
            $table->string('deskripsi')->nullable();
            $table->string('jenjang');
            $table->string('jenis_perhitungan');
            $table->string('isian_rumus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_sub_standars');
    }
};
