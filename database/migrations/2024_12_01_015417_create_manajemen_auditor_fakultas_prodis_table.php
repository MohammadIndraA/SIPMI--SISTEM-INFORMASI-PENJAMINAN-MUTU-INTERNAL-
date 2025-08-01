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
        Schema::create('manajemen_auditor_fakultas_prodis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manajemen_auditor_id')->constrained('manajemen_auditors');
            $table->foreignId('fakultas_prodi_id')->constrained('fakultas_prodis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manajemen_auditor_fakultas_prodis');
    }
};
