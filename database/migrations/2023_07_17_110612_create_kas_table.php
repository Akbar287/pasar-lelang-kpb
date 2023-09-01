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
        Schema::create('kas', function (Blueprint $table) {
            $table->uuid('kas_id')->primary();
            $table->uuid('detail_jaminan_id');
            $table->uuid('kurs_mata_uang_id');
            $table->decimal('nilai', 18, 2);
            $table->string('kode_mata_uang', 8);
            $table->decimal('nilai_penyesuaian', 18, 2);
            $table->text('keterangan')->nullable();

            $table->foreign('detail_jaminan_id')->references('detail_jaminan_id')->on('detail_jaminan')->cascadeOnDelete();
            $table->foreign('kurs_mata_uang_id')->references('kurs_mata_uang_id')->on('kurs_mata_uang')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas');
    }
};
