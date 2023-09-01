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
        Schema::create('lembaga', function (Blueprint $table) {
            $table->uuid('lembaga_id')->primary();
            $table->uuid('informasi_akun_id');
            $table->uuid('status_member_id');
            $table->uuid('npwp_id');
            $table->string('nama_lembaga', 64);
            $table->string('bidang_usaha', 64);
            $table->boolean('is_aktif');
            $table->timestamps();

            $table->foreign('informasi_akun_id')->references('informasi_akun_id')->on('informasi_akun')->cascadeOnDelete();
            $table->foreign('npwp_id')->references('npwp_id')->on('npwp')->cascadeOnDelete();
            $table->foreign('status_member_id')->references('status_member_id')->on('status_member')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lembaga');
    }
};
