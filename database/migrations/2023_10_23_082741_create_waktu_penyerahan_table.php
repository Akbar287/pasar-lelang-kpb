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
        Schema::create('waktu_penyerahan', function (Blueprint $table) {
            $table->uuid('waktu_penyerahan_id')->primary();
            $table->uuid('nomor_surat_id');
            $table->date('tanggal');
            $table->decimal('volume', 19, 2);

            $table->foreign('nomor_surat_id')->references('nomor_surat_id')->on('nomor_surat')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waktu_penyerahan');
    }
};
