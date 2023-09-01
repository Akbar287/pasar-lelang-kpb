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
            $table->string('registrasi_id', 32);
            $table->string('nama_profile', 128);
            $table->boolean('is_open');
            $table->date('tanggal_register');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
