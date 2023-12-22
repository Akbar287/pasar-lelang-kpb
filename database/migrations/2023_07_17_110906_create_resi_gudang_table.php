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
        Schema::create('resi_gudang', function (Blueprint $table) {
            $table->uuid('resi_gudang_id')->primary();
            $table->uuid('surat_berharga_id');
            $table->string('jenis', 128);
            $table->string('pemilik_barang', 128);
            $table->string('pemegang_resi_gudang', 128);
            $table->string('no_penerbitan', 64);
            $table->string('nama_resi_gudang', 128);
            $table->decimal('nilai_resi_gudang', 18, 2);
            $table->decimal('haircut', 18, 2);
            $table->decimal('nilai_tersedia', 18, 2);
            $table->date('tanggal_penerbitan', 18, 2);
            $table->date('tanggal_jatuh_tempo', 18, 2);

            $table->foreign('surat_berharga_id')->references('surat_berharga_id')->on('surat_berharga')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resi_gudang');
    }
};
