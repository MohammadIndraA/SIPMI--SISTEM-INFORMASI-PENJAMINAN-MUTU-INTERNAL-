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
        Schema::create('rencana_tindak_lanjuts', function (Blueprint $table) {
            $table->id();
            $table->text('root_cause');
            $table->text('action_plan');
            $table->text('Rekomendasi');
            $table->text('person_in_charge');
            $table->text('target_waktu_penyelesaian');
            $table->foreignId('poin_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rencana_tindak_lanjuts');
    }
};
