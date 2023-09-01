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
        Schema::create('gudang', function (Blueprint $table) {
            $table->uuid('gudang_id')->primary();
            $table->uuid('penyelenggara_pasar_lelang_id');
            $table->string('gudang_kode', 64);
            $table->string('nama_gudang', 128);
            $table->string('contact_person', 128);
            $table->string('contact_number', 16);
            $table->string('nama_pengelola', 128);
            $table->text('keterangan')->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('penyelenggara_pasar_lelang_id')->references('penyelenggara_pasar_lelang_id')->on('penyelenggara_pasar_lelang')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gudang');
    }
};
