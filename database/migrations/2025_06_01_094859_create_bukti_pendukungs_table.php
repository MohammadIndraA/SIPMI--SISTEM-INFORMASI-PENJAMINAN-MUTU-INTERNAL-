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
        Schema::create('bukti_pendukungs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('file_pendukung');
            $table->string('unit_pengunggah');
            $table->foreignId('kategori_dokumen_id')->constrained()->onDelete('cascade');
            $table->foreignId('poin_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('daftar_sub_standar_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukti_pendukungs');
    }
};
