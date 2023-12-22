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
        Schema::create('pengeluaran_jaminan', function (Blueprint $table) {
            $table->uuid('pengeluaran_jaminan_id')->primary();
            $table->uuid('jaminan_id');
            $table->uuid('jenis_pengeluaran_jaminan_id');
            $table->string('kode_transaksi', 64);
            $table->date('tanggal');
            $table->boolean('is_aktif');
            $table->text('keterangan')->nullable();
            $table->decimal('jumlah, 18, 2');

            $table->foreign('jaminan_id')->references('jaminan_id')->on('jaminan')->cascadeOnDelete();
            $table->foreign('jenis_pengeluaran_jaminan_id')->references('jenis_pengeluaran_jaminan_id')->on('jenis_pengeluaran_jaminan')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran_jaminan');
    }
};
