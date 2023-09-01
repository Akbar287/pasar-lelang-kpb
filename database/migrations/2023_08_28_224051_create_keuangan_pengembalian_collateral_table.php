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
        Schema::create('keuangan_pengembalian_collateral', function (Blueprint $table) {
            $table->uuid('keuangan_pengembalian_collateral_id')->primary();
            $table->uuid('keuangan_id');
            $table->uuid('rekening_bank_id');

            $table->foreign('keuangan_id')->references('keuangan_id')->on('keuangan')->cascadeOnDelete();
            $table->foreign('rekening_bank_id')->references('rekening_bank_id')->on('rekening_bank')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangan_pengembalian_collateral');
    }
};
