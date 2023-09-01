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
        Schema::create('return_cash', function (Blueprint $table) {
            $table->uuid('return_cash_id')->primary();
            $table->uuid('pengeluaran_jaminan_id');
            $table->decimal('jaminan_tersedia', 18, 2);
            $table->decimal('jumlah_pengembalian', 18, 2);

            $table->foreign('pengeluaran_jaminan_id')->references('pengeluaran_jaminan_id')->on('pengeluaran_jaminan')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_cash');
    }
};
