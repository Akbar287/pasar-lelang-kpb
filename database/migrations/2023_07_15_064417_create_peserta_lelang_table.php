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
        Schema::create('peserta_lelang', function (Blueprint $table) {
            $table->uuid('peserta_lelang_id')->primary();
            $table->uuid('informasi_akun_id');
            $table->uuid('master_sesi_lelang_id');
            $table->date('tanggal');
            $table->string('kode_peserta_lelang', 8);
            $table->timestamps();

            $table->foreign('informasi_akun_id')->references('informasi_akun_id')->on('informasi_akun')->cascadeOnDelete();
            $table->foreign('master_sesi_lelang_id')->references('master_sesi_lelang_id')->on('master_sesi_lelang')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta_lelang');
    }
};
