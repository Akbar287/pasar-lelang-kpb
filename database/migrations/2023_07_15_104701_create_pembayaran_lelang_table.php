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
        Schema::create('pembayaran_lelang', function (Blueprint $table) {
            $table->uuid('pembayaran_lelang_id')->primary();
            $table->uuid('status_penyelesaian_id');
            $table->uuid('approval_lelang_id');
            $table->string('nomor_lelang')->nullable();
            $table->date('tanggal_pembayaran');
            $table->date('tanggal_jatuh_tempo');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('status_penyelesaian_id')->references('status_penyelesaian_id')->on('status_penyelesaian')->cascadeOnDelete();
            $table->foreign('approval_lelang_id')->references('approval_lelang_id')->on('approval_lelang')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_lelang');
    }
};
