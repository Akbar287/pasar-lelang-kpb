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
        Schema::create('dokumen_member', function (Blueprint $table) {
            $table->uuid('dokumen_member_id')->primary();
            $table->uuid('jenis_dokumen_id');
            $table->uuid('informasi_akun_id');
            $table->string('versi_unggah', 32);
            $table->date('tanggal_unggah');
            $table->string('nama_dokumen', 128);
            $table->string('nama_file', 128);

            $table->foreign('jenis_dokumen_id')->references('jenis_dokumen_id')->on('jenis_dokumen')->cascadeOnDelete();
            $table->foreign('informasi_akun_id')->references('informasi_akun_id')->on('informasi_akun')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_member');
    }
};
