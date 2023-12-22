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
        Schema::create('blog_post', function (Blueprint $table) {
            $table->uuid('blog_post_id')->primary();
            $table->uuid('admin_id');
            $table->string('title', 75);
            $table->string('slug', 100);
            $table->string('summary', 255);
            $table->text('content');
            $table->boolean('published')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('admin_id')->references('admin_id')->on('admin')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_post');
    }
};
