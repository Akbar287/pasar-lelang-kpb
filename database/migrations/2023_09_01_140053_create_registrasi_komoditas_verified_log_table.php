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
        Schema::create('registrasi_komoditas_verified_log', function (Blueprint $table) {
            $table->uuid('registrasi_komoditas_id');
            $table->uuid('verified_log_id');

            $table->primary(['registrasi_komoditas_id', 'verified_log_id']);

            $table->foreign('registrasi_komoditas_id')->references('registrasi_komoditas_id')->on('registrasi_komoditas')->cascadeOnDelete();
            $table->foreign('verified_log_id')->references('verified_log_id')->on('verified_log')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrasi_komoditas_verified_log');
    }
};
