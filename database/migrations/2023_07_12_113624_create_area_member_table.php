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
        Schema::create('area_member', function (Blueprint $table) {
            $table->uuid('area_member_id')->primary();
            $table->uuid('desa_id');
            $table->string('kode_pos', 5);
            $table->string('alamat', 128);
            $table->integer('alamat_ke');
            $table->timestamps();

            $table->foreign('desa_id')->references('desa_id')->on('desa')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('area_member');
    }
};
