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
        Schema::create('dokumen_produk', function (Blueprint $table) {
            $table->uuid('dokumen_produk_id')->primary();
            $table->uuid('jenis_dokumen_produk_id');
            $table->uuid('lelang_id');
            $table->text('keterangan')->nullable();
            $table->string('nama_dokumen', 128);
            $table->string('nama_file', 128);
            $table->date('tanggal_upload');
            $table->boolean('is_gambar_utama');

            $table->foreign('jenis_dokumen_produk_id')->references('jenis_dokumen_produk_id')->on('jenis_dokumen_produk')->cascadeOnDelete();
            $table->foreign('lelang_id')->references('lelang_id')->on('lelang')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_produk');
    }
};
