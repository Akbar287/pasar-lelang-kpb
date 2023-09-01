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
        Schema::create('jaminan_komoditas', function (Blueprint $table) {
            $table->uuid('jaminan_komoditas_id')->primary();
            $table->uuid('pengeluaran_jaminan_id');
            $table->uuid('dokumen_settlement_id');
            $table->decimal('qty_jaminan', 18, 2);
            $table->decimal('nilai_jaminan', 18, 2);
            $table->string('komoditi');
            $table->decimal('qty_settlement', 18, 2);
            $table->decimal('qty_auction', 18, 2);
            $table->decimal('qty_settled', 18, 2);
            $table->decimal('alokasi_settlement', 18, 2);

            $table->foreign('pengeluaran_jaminan_id')->references('pengeluaran_jaminan_id')->on('pengeluaran_jaminan')->cascadeOnDelete();
            $table->foreign('dokumen_settlement_id')->references('dokumen_settlement_id')->on('dokumen_settlement')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jaminan_komoditas');
    }
};
