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
        Schema::create('keuangan', function (Blueprint $table) {
            $table->uuid('keuangan_id')->primary();
            $table->uuid('rekening_bank_id');
            $table->uuid('jenis_transaksi_id');
            $table->uuid('kurs_mata_uang_id');
            $table->decimal('jumlah', 16);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('rekening_bank_id')->references('rekening_bank_id')->on('rekening_bank')->cascadeOnDelete();
            $table->foreign('jenis_transaksi_id')->references('jenis_transaksi_id')->on('jenis_transaksi')->cascadeOnDelete();
            $table->foreign('kurs_mata_uang_id')->references('kurs_mata_uang_id')->on('kurs_mata_uang')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangan');
    }
};
