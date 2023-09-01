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
        Schema::create('keuangan_cash_non_trading', function (Blueprint $table) {
            $table->uuid('keuangan_cash_non_trading_id')->primary();
            $table->uuid('keuangan_id');
            $table->decimal('saldo_belum_teralokasi', 18, 2);

            $table->foreign('keuangan_id')->references('keuangan_id')->on('keuangan')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangan_cash_non_trading');
    }
};
