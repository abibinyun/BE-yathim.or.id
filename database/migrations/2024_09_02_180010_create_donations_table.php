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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade'); // Relasi ke tabel kampanye, jika kampanye dihapus, donasi terkait juga dihapus (cascade)
            $table->decimal('amount', 10, 2); // Jumlah donasi
            $table->string('payment_method'); // Metode pembayaran
            $table->string('bank_account'); // Akun bank yang digunakan untuk pembayaran
            $table->string('transaction_id')->nullable(); // ID transaksi (opsional)
            $table->enum('status', ['pending', 'success', 'failed', 'refunded'])->default('pending'); // Status donasi
            $table->string('payment_proof')->nullable(); // Bukti pembayaran (opsional)
            $table->text('notes')->nullable(); // Catatan tambahan (opsional)
            $table->boolean('is_confrim')->default(false);
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
