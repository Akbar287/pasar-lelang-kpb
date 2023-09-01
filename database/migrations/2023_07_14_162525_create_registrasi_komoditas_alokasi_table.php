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
        Schema::create('registrasi_komoditas_alokasi', function (Blueprint $table) {
            $table->uuid('registrasi_komoditas_alokasi_id')->primary();
            $table->uuid('registrasi_komoditas_id');
            $table->decimal('sisa_alokasi_saldo', 18, 2);
            $table->decimal('saldo_belum_teralokasi', 18, 2);
            $table->decimal('alokasi_kolateral', 18, 2);
            $table->decimal('alokasi_penyelesaian', 18, 2);
            $table->decimal('alokasi_lain', 18, 2);
            $table->string('type_alokasi', 32);

            $table->foreign('registrasi_komoditas_id')->references('registrasi_komoditas_id')->on('registrasi_komoditas')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrasi_komoditas_alokasi');
    }
};
