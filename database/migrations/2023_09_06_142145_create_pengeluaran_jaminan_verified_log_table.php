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
        Schema::create('pengeluaran_jaminan_verified_log', function (Blueprint $table) {
            $table->uuid('pengeluaran_jaminan_id');
            $table->uuid('verified_log_id');

            $table->primary(['pengeluaran_jaminan_id', 'verified_log_id']);

            $table->foreign('pengeluaran_jaminan_id')->references('pengeluaran_jaminan_id')->on('pengeluaran_jaminan')->cascadeOnDelete();
            $table->foreign('verified_log_id')->references('verified_log_id')->on('verified_log')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran_jaminan_verified_log');
    }
};
