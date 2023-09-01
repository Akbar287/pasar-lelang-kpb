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
        Schema::create('area_member_informasi_akun', function (Blueprint $table) {
            $table->uuid('area_member_id');
            $table->uuid('informasi_akun_id');
            $table->primary(['area_member_id', 'informasi_akun_id']);

            $table->foreign('area_member_id')->references('area_member_id')->on('area_member')->cascadeOnDelete();
            $table->foreign('informasi_akun_id')->references('informasi_akun_id')->on('informasi_akun')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('area_member_informasi_akun');
    }
};
