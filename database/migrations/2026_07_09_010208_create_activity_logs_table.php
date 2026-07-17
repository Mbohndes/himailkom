<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // Siapa pelakunya
            $table->string('module'); // Modul apa (Contoh: 'Keuangan', 'Keanggotaan')
            $table->string('action'); // Aksi (Contoh: 'CREATE', 'UPDATE', 'DELETE', 'LOGIN')
            $table->text('description'); // Deskripsi detail
            $table->string('ip_address')->nullable(); // Alamat IP pengguna
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};