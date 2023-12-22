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
        Schema::create('daftar_peserta_lelang_aktif', function (Blueprint $table) {
            $table->uuid('daftar_peserta_lelang_aktif_id')->primary();
            $table->uuid('event_lelang_id');
            $table->uuid('lelang_id');
            $table->date('waktu_mulai');
            $table->date('waktu_selesai');
            $table->boolean('aktif')->default(false);

            $table->foreign('event_lelang_id')->references('event_lelang_id')->on('event_lelang')->cascadeOnDelete();
            $table->foreign('lelang_id')->references('lelang_id')->on('lelang')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_peserta_lelang_aktif');
    }
};
