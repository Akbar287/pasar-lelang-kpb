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
        Schema::create('release_cash', function (Blueprint $table) {
            $table->uuid('release_cash_id')->primary();
            $table->uuid('pengeluaran_jaminan_id');
            $table->uuid('dokumen_settlement_id');
            $table->decimal('jaminan_tersedia', 18, 2);
            $table->decimal('jaminan_terpakai', 18, 2);
            $table->decimal('total_jaminan', 18, 2);
            $table->decimal('jumlah', 18, 2);

            $table->foreign('pengeluaran_jaminan_id')->references('pengeluaran_jaminan_id')->on('pengeluaran_jaminan')->cascadeOnDelete();
            $table->foreign('dokumen_settlement_id')->references('dokumen_settlement_id')->on('dokumen_settlement')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('release_cash');
    }
};
