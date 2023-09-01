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
        Schema::create('detail_jaminan', function (Blueprint $table) {
            $table->uuid('detail_jaminan_id')->primary();
            $table->uuid('jaminan_id');
            $table->date('tanggal_transaksi');
            $table->decimal('nilai_jaminan', 18, 2);
            $table->decimal('nilai_penyesuaian', 18, 2);
            $table->boolean('is_aktif');

            $table->foreign('jaminan_id')->references('jaminan_id')->on('jaminan')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_jaminan');
    }
};
