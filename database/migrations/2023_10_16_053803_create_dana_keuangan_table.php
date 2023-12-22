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
        Schema::create('dana_keuangan', function (Blueprint $table) {
            $table->uuid('dana_keuangan_id')->primary();
            $table->uuid('verified_log_id');
            $table->uuid('rekening_pusat_id');
            $table->string('jenis', 16);
            $table->decimal('jumlah_dana', 19, 2);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('verified_log_id')->references('verified_log_id')->on('verified_log')->cascadeOnDelete();
            $table->foreign('rekening_pusat_id')->references('rekening_pusat_id')->on('rekening_pusat')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dana_keuangan');
    }
};
