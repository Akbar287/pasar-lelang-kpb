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
        Schema::create('pembayaran_lelang_verified_log', function (Blueprint $table) {
            $table->uuid('pembayaran_lelang_id');
            $table->uuid('verified_log_id');

            $table->primary(['pembayaran_lelang_id', 'verified_log_id']);

            $table->foreign('pembayaran_lelang_id')->references('pembayaran_lelang_id')->on('pembayaran_lelang')->cascadeOnDelete();
            $table->foreign('verified_log_id')->references('verified_log_id')->on('verified_log')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_lelang_verified_log');
    }
};
