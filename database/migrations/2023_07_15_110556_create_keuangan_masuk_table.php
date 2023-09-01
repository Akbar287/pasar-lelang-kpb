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
        Schema::create('keuangan_masuk', function (Blueprint $table) {
            $table->uuid('keuangan_masuk_id')->primary();
            $table->uuid('pembayaran_lelang_id');
            $table->uuid('rekening_bank_id');
            $table->date('tanggal_instruksi');
            $table->string('no_instruksi', 64);
            $table->string('no_faktur', 64);
            $table->text('status')->nullable();

            $table->foreign('pembayaran_lelang_id')->references('pembayaran_lelang_id')->on('pembayaran_lelang')->cascadeOnDelete();
            $table->foreign('rekening_bank_id')->references('rekening_bank_id')->on('rekening_bank')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangan_masuk');
    }
};
