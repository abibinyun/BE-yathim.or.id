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
            // Menambahkan kolom recommended_campaign_ids yang menyimpan array ID campaign yang direkomendasikan
            $table->json('recommended_campaign_ids')->nullable(); // Menyimpan array ID campaign dalam format JSON
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Menghapus kolom recommended_campaign_ids
            $table->dropColumn('recommended_campaign_ids');
        });
    }
};
