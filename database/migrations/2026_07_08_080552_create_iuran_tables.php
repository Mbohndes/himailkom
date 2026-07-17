<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Master Jenis Iuran (Tagihan)
        Schema::create('dues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id')->constrained()->restrictOnDelete();
            $table->string('name'); // Contoh: "Kas Minggu 1 Juli", "Iuran Makrab"
            $table->enum('type', ['Kas Rutin', 'Iuran Kegiatan', 'Lainnya'])->default('Kas Rutin');
            $table->decimal('amount', 12, 2); // Nominal yang harus dibayar
            $table->date('due_date'); // Jatuh Tempo
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 2. Tabel Data Pembayaran (Setoran Anggota)
        Schema::create('due_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('due_id')->constrained('dues')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            
            $table->decimal('amount_paid', 12, 2)->default(0); // Jumlah yang sudah dibayar
            $table->enum('status', ['Lunas', 'Belum Lunas', 'Terlambat'])->default('Belum Lunas');
            $table->string('payment_method')->nullable(); // Cash, Transfer Bank, e-Wallet
            $table->string('proof_of_payment')->nullable(); // Upload foto bukti transfer
            $table->text('notes')->nullable();
            
            $table->dateTime('paid_at')->nullable(); // Waktu pembayaran disahkan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('due_payments');
        Schema::dropIfExists('dues');
    }
};