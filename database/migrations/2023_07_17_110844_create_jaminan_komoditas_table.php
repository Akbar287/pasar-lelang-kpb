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
            $table->uuid('registrasi_komoditas_jaminan_id');
            $table->decimal('qty_settlement', 18, 2);
            $table->decimal('alokasi_settlement', 18, 2);

            $table->foreign('pengeluaran_jaminan_id')->references('pengeluaran_jaminan_id')->on('pengeluaran_jaminan')->cascadeOnDelete();
            $table->foreign('registrasi_komoditas_jaminan_id')->references('registrasi_komoditas_jaminan_id')->on('registrasi_komoditas_jaminan')->cascadeOnDelete();
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
