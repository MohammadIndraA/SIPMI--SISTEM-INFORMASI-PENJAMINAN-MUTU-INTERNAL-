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
        Schema::create('jawabans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('daftar_sub_standar_id');
            $table->foreign('daftar_sub_standar_id')->references('id')->on('daftar_sub_standars')->onDelete('cascade');
            $table->unsignedBigInteger('poin_id');
            $table->foreign('poin_id')->references('id')->on('poins')->onDelete('cascade');
            $table->string('jawaban');
            $table->string('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawabans');
    }
};
