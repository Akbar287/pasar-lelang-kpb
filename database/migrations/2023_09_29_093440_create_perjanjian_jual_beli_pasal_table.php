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
        Schema::create('perjanjian_jual_beli_pasal', function (Blueprint $table) {
            $table->uuid('perjanjian_jual_beli_pasal_id')->primary();
            $table->string('key', 32);
            $table->text('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perjanjian_jual_beli_pasal');
    }
};
