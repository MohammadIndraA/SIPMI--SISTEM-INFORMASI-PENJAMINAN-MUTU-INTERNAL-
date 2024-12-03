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
        Schema::create('manajemen_auditors', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('nama_assesor');
            $table->foreignId('lembaga_akreditasi_id')->constrained('lembaga_akreditasis');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('instansi');
            $table->string('gelar_awal');
            $table->string('gelar_akhir');
            $table->string('jabatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manajemen_auditors');
    }
};
