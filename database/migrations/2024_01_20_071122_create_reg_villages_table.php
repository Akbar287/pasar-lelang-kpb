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
        Schema::create('reg_villages', function (Blueprint $table) {
            $table->string('id', 5)->primary();
            $table->string('district_id', 2);
            $table->string('name');

            $table->foreign('district_id')->references('id')->on('reg_districts')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reg_villages');
    }
};
