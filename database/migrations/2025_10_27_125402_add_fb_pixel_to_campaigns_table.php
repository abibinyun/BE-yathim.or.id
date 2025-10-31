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
        // Menambahkan kolom facebook_pixel ke tabel campaigns
        Schema::table('campaigns', function (Blueprint $table) {
            $table->string('facebook_pixel')->nullable(); // Kolom facebook_pixel dengan default null
        });

        // Menambahkan kolom facebook_pixel ke tabel articles
        Schema::table('articles', function (Blueprint $table) {
            $table->string('facebook_pixel')->nullable(); // Kolom facebook_pixel dengan default null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus kolom facebook_pixel dari tabel campaigns
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn('facebook_pixel');
        });

        // Menghapus kolom facebook_pixel dari tabel articles
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('facebook_pixel');
        });
    }
};
