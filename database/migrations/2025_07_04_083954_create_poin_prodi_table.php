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
        Schema::create('poin_prodi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('poin_id');
            $table->unsignedBigInteger('fakultas_prodi_id');

            $table->foreign('poin_id')->references('id')->on('poins')->onDelete('cascade');
            $table->foreign('fakultas_prodi_id')->references('id')->on('fakultas_prodis')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poin_prodi');
    }
};
