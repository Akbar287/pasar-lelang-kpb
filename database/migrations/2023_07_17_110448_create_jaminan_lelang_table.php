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
        Schema::create('jaminan_lelang', function (Blueprint $table) {
            $table->uuid('jaminan_lelang_id')->primary();
            $table->uuid('pengeluaran_jaminan_id');
            $table->uuid('lelang_id');
            $table->decimal('nilai_jaminan', 18, 2);
            $table->decimal('total_jaminan_disetor', 18, 2);
            $table->boolean('is_jaminan_dilepas');

            $table->foreign('pengeluaran_jaminan_id')->references('pengeluaran_jaminan_id')->on('pengeluaran_jaminan')->cascadeOnDelete();
            $table->foreign('lelang_id')->references('lelang_id')->on('lelang')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jaminan_lelang');
    }
};
