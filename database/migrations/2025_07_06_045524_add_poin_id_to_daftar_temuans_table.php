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
        Schema::table('daftar_temuans', function (Blueprint $table) {
            $table->unsignedBigInteger('poin_id')->after('fakultas_prodi_id');
            $table->foreign('poin_id')->references('id')->on('poins');
            $table->unsignedBigInteger('user_id')->after('poin_id');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daftar_temuans', function (Blueprint $table) {
            $table->dropForeign(['poin_id']);
            $table->dropForeign(['user_id']); 
        });
    }
};
