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
        Schema::create('lelang', function (Blueprint $table) {
            $table->uuid('lelang_id')->primary();
            $table->uuid('jenis_perdagangan_id');
            $table->uuid('jenis_inisiasi_id');
            $table->uuid('kontrak_id');
            $table->uuid('jenis_harga_id');
            $table->string('nomor_lelang', 32);
            $table->string('asal_komoditas', 128);
            $table->integer('kuantitas');
            $table->string('judul');
            $table->text('spesifikasi_produk');
            $table->string('kemasan', 128);
            $table->text('lokasi_penyerahan');
            $table->decimal('harga_awal', 18, 2);
            $table->decimal('kelipatan_penawaran', 18, 2);
            $table->decimal('harga_beli_sekarang', 18, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('jenis_perdagangan_id')->references('jenis_perdagangan_id')->on('jenis_perdagangan')->cascadeOnDelete();
            $table->foreign('jenis_harga_id')->references('jenis_harga_id')->on('jenis_harga')->cascadeOnDelete();
            $table->foreign('kontrak_id')->references('kontrak_id')->on('kontrak')->cascadeOnDelete();
            $table->foreign('jenis_inisiasi_id')->references('jenis_inisiasi_id')->on('jenis_inisiasi')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lelang');
    }
};
