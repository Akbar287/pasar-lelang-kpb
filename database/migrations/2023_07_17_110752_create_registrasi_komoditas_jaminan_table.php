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
        Schema::create('registrasi_komoditas_jaminan', function (Blueprint $table) {
            $table->uuid('registrasi_komoditas_jaminan_id')->primary();
            $table->uuid('detail_jaminan_id');
            $table->string('komoditi', 255);
            $table->date('kadaluarsa');
            $table->decimal('kuantitas', 18, 2);
            $table->string('unit', 8);
            $table->decimal('nilai_perkiraan', 18, 2);
            $table->decimal('haircut', 18, 2);
            $table->decimal('nilai_penyesuaian', 18, 2);
            $table->string('lokasi');

            $table->foreign('detail_jaminan_id')->references('detail_jaminan_id')->on('detail_jaminan')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrasi_komoditas_jaminan');
    }
};
