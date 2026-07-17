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
    Schema::create('expenses', function (Blueprint $table) {
        $table->id();
        $table->string('description'); // Nama keperluan pengeluaran
        $table->decimal('amount', 15, 2); // Jumlah uang keluar
        $table->date('date'); // Tanggal transaksi
        $table->string('proof_image')->nullable(); // Bukti foto nota/kwitansi
        $table->foreignId('user_id')->constrained(); // Siapa yang mencatat
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
