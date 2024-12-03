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
            Schema::create('pengaturan_periode_standar_nasionals', function (Blueprint $table) {
                $table->id();
                // Berikan nama constraint secara manual
                    $table->unsignedBigInteger('pengaturan_periode_id');
                    $table->foreign('pengaturan_periode_id', 'fk_pengaturan_periode')
                        ->references('id')
                        ->on('pengaturan_periodes')
                        ->onUpdate('CASCADE')
                        ->onDelete('RESTRICT');

                    $table->unsignedBigInteger('standar_nasional_id');
                    $table->foreign('standar_nasional_id', 'fk_standar_nasional')
                        ->references('id')
                        ->on('standar_nasionals')
                        ->onUpdate('CASCADE')
                        ->onDelete('RESTRICT');
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan_periode_standar_nasionals');
    }
};
