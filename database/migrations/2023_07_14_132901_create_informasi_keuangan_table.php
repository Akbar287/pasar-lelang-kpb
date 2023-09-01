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
        Schema::create('informasi_keuangan', function (Blueprint $table) {
            $table->uuid('informasi_keuangan_id')->primary();
            $table->uuid('npwp_id');
            $table->uuid('member_id');
            $table->string('pekerjaan', 128);
            $table->string('pendapatan_tahunan', 128);
            $table->decimal('kekayaan_bersih', 18, 2);
            $table->decimal('kekayaan_lancar', 18, 2);
            $table->string('sumber_dana', 32);
            $table->text('keterangan')->nullable();

            $table->foreign('member_id')->references('member_id')->on('member')->cascadeOnDelete();
            $table->foreign('npwp_id')->references('npwp_id')->on('npwp')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_keuangan');
    }
};
