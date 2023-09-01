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
        Schema::create('daftar_peserta_lelang', function (Blueprint $table) {
            $table->uuid('daftar_peserta_lelang_id')->primary();
            $table->uuid('event_lelang_id');
            $table->uuid('informasi_akun_id');
            $table->string('kode_peserta_lelang', 8);

            $table->foreign('event_lelang_id')->references('event_lelang_id')->on('event_lelang')->cascadeOnDelete();
            $table->foreign('informasi_akun_id')->references('informasi_akun_id')->on('informasi_akun')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_peserta_lelang');
    }
};
