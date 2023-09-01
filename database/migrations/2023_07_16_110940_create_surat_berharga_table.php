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
        Schema::create('surat_berharga', function (Blueprint $table) {
            $table->uuid('surat_berharga_id')->primary();
            $table->uuid('detail_jaminan_id');
            $table->uuid('jenis_surat_berharga_id');

            $table->foreign('detail_jaminan_id')->references('detail_jaminan_id')->on('detail_jaminan')->cascadeOnDelete();
            $table->foreign('jenis_surat_berharga_id')->references('jenis_surat_berharga_id')->on('jenis_surat_berharga')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_berharga');
    }
};
