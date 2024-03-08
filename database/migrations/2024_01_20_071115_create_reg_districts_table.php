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
        Schema::create('reg_districts', function (Blueprint $table) {
            $table->string('id', 5)->primary();
            $table->string('regency_id', 2);
            $table->string('name');

            $table->foreign('regency_id')->references('id')->on('reg_regencies')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reg_districts');
    }
};
