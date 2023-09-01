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
        Schema::create('file_keuangan_pengembalian_collateral', function (Blueprint $table) {
            $table->uuid('file_keuangan_cash_pengembalian_collateral_id')->primary();
            $table->uuid('keuangan_pengembalian_collateral_id');
            $table->string('nama_file', 128);
            $table->string('nama_dokumen', 128);
            $table->date('tanggal_upload');

            $table->foreign('keuangan_pengembalian_collateral_id')->references('keuangan_pengembalian_collateral_id')->on('keuangan_pengembalian_collateral')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_keuangan_pengembalian_collateral');
    }
};
