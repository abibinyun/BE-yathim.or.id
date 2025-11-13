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
        Schema::table('articles', function (Blueprint $table) {
            // Menambahkan kolom recommended_article_ids yang menyimpan array ID artikel yang direkomendasikan
            $table->json('recommended_article_ids')->nullable(); // Menyimpan array ID artikel dalam format JSON
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Menghapus kolom recommended_article_ids
            $table->dropColumn('recommended_article_ids');
        });
    }
};
