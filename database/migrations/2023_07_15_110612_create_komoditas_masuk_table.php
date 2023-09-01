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
        Schema::create('komoditas_masuk', function (Blueprint $table) {
            $table->uuid('komoditas_masuk_id')->primary();
            $table->uuid('pembayaran_lelang_id');
            $table->date('tanggal_instruksi');
            $table->string('no_instruksi', 64);
            $table->string('no_faktur', 64);
            $table->text('status')->nullable();

            $table->foreign('pembayaran_lelang_id')->references('pembayaran_lelang_id')->on('pembayaran_lelang')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komoditas_masuk');
    }
};
