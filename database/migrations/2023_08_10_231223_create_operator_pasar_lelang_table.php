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
        Schema::create('operator_pasar_lelang', function (Blueprint $table) {
            $table->uuid('operator_pasar_lelang_id')->primary();
            $table->uuid('offline_profile_id');
            $table->string('user_id', 32);
            $table->string('nama_lengkap', 128);
            $table->string('password');
            $table->boolean('is_aktif');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('offline_profile_id')->references('offline_profile_id')->on('offline_profile')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operator_pasar_lelang');
    }
};
