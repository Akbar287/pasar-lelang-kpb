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
        Schema::create('verified_log', function (Blueprint $table) {
            $table->uuid('verified_log_id')->primary();
            $table->uuid('informasi_akun_id');
            $table->uuid('admin_id');
            $table->uuid('jenis_verifikasi_id');
            $table->boolean('is_agree');
            $table->timestamp('tanggal_verifikasi');
            $table->text('keterangan')->nullable();

            $table->foreign('informasi_akun_id')->references('informasi_akun_id')->on('informasi_akun')->cascadeOnDelete();
            $table->foreign('jenis_verifikasi_id')->references('jenis_verifikasi_id')->on('jenis_verifikasi')->cascadeOnDelete();
            $table->foreign('admin_id')->references('admin_id')->on('admin')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verified_log');
    }
};
