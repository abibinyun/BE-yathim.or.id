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
        Schema::create('page_banners', function (Blueprint $table) {
            $table->id();
            $table->enum('page_identifier', ['none', 'home', 'campaign', 'gallery', 'article', 'about'])->default('none')->unique(); // Status donasi
            $table->string('banner_image');
            $table->string('title');
            $table->string('subtitle');
            $table->boolean('isVideo')->default(false);
            $table->boolean('isButton')->default(false);
            $table->string('video')->default('link-video');
            $table->string('button_text')->default('text-button');
            $table->string('button_link')->default('link-button');
            $table->json('video_slides')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_banners');
    }
};
