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
        Schema::create('setting_collateral', function (Blueprint $table) {
            $table->uuid('setting_collateral_id')->primary();
            $table->uuid('member_id');
            $table->uuid('jenis_inisiasi_id');
            $table->boolean('is_aktif');
            $table->timestamps();

            $table->foreign('member_id')->references('member_id')->on('member')->cascadeOnDelete();
            $table->foreign('jenis_inisiasi_id')->references('jenis_inisiasi_id')->on('jenis_inisiasi')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_collateral');
    }
};
