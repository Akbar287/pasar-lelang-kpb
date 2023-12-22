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
        Schema::create('status_registrasi_komoditas', function (Blueprint $table) {
            $table->uuid('status_registrasi_komoditas_id')->primary();
            $table->string('nama_status', 64);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_registrasi_komoditas');
    }
};
