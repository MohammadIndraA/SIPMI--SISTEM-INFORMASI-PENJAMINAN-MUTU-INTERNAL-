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
        Schema::create('poins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daftar_sub_standar_id')->constrained('daftar_sub_standars');
            $table->text('nama_poin');
            $table->text('deskripsi')->nullable();
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
        Schema::dropIfExists('poins');
    }
};
