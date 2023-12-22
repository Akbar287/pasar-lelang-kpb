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
        Schema::create('offline_profile', function (Blueprint $table) {
            $table->uuid('offline_profile_id')->primary();
            $table->uuid('penyelenggara_pasar_lelang_id');
            $table->uuid('userlogin_id');
            $table->string('registrasi_id', 32);
            $table->string('nama_profile', 128);
            $table->boolean('is_open');
            $table->date('tanggal_register');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('penyelenggara_pasar_lelang_id')->references('penyelenggara_pasar_lelang_id')->on('penyelenggara_pasar_lelang')->cascadeOnDelete();
            $table->foreign('userlogin_id')->references('userlogin_id')->on('userlogin')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offline_profile');
    }
};
