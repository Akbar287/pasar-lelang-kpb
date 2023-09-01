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
        Schema::create('daftar_peserta_lelang_berlangsung', function (Blueprint $table) {
            $table->uuid('daftar_peserta_lelang_berlangsung_id')->primary();
            $table->uuid('daftar_peserta_lelang_id');
            $table->uuid('lelang_id');
            $table->decimal('harga_ajuan', 18, 2);
            $table->integer('waktu');
            $table->timestamps();

            $table->foreign('daftar_peserta_lelang_id')->references('daftar_peserta_lelang_id')->on('daftar_peserta_lelang')->cascadeOnDelete();
            $table->foreign('lelang_id')->references('lelang_id')->on('lelang')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_peserta_lelang_berlangsung');
    }
};
