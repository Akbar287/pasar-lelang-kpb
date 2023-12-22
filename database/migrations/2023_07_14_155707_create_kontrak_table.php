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
        Schema::create('kontrak', function (Blueprint $table) {
            $table->uuid('kontrak_id')->primary();
            $table->uuid('penyelenggara_pasar_lelang_id');
            $table->uuid('komoditas_id');
            $table->uuid('jenis_perdagangan_id');
            $table->uuid('mutu_id');
            $table->uuid('status_kontrak_id');
            $table->uuid('informasi_akun_id');
            $table->string('kontrak_kode', 64);
            $table->string('simbol', 32)->nullable();
            $table->decimal('minimum_transaksi', 18, 2)->nullable();
            $table->decimal('maksimum_transaksi', 18, 2)->nullable();
            $table->decimal('fluktuasi_harga_harian', 18, 2)->nullable();
            $table->decimal('premium', 18, 2)->nullable();
            $table->decimal('diskon', 18, 2)->nullable();
            $table->decimal('jatuh_tempo_t_plus', 18, 2)->nullable();
            $table->date('tanggal_aktif')->nullable();
            $table->date('tanggal_berakhir')->nullable();
            $table->text('keterangan')->nullable();
            $table->date('tanggal_verifikasi')->nullable();
            $table->boolean('is_aktif');
            $table->boolean('is_verified');
            $table->boolean('is_status_verified');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('penyelenggara_pasar_lelang_id')->references('penyelenggara_pasar_lelang_id')->on('penyelenggara_pasar_lelang')->cascadeOnDelete();
            $table->foreign('komoditas_id')->references('komoditas_id')->on('komoditas')->cascadeOnDelete();
            $table->foreign('jenis_perdagangan_id')->references('jenis_perdagangan_id')->on('jenis_perdagangan')->cascadeOnDelete();
            $table->foreign('informasi_akun_id')->references('informasi_akun_id')->on('informasi_akun')->cascadeOnDelete();
            $table->foreign('status_kontrak_id')->references('status_kontrak_id')->on('status_kontrak')->cascadeOnDelete();
            $table->foreign('mutu_id')->references('mutu_id')->on('mutu')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontrak');
    }
};
