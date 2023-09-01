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
        Schema::create('rekening_keuangan_asal', function (Blueprint $table) {
            $table->uuid('rekening_keuangan_asal_id')->primary();
            $table->uuid('keuangan_keluar_id');
            $table->uuid('rekening_bank_id');
            $table->enum('jenis_rekening', ['asal', 'tujuan']);

            $table->foreign('keuangan_keluar_id')->references('keuangan_keluar_id')->on('keuangan_keluar')->cascadeOnDelete();
            $table->foreign('rekening_bank_id')->references('rekening_bank_id')->on('rekening_bank')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekening_keuangan_asal');
    }
};
