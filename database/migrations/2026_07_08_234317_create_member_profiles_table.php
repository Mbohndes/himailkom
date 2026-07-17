<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_profiles', function (Blueprint $table) {
            $table->id();
            // Relasi abadi ke tabel users (akun utama)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Biodata Lanjutan
            $table->string('place_of_birth')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();
            $table->string('phone_emergency')->nullable();
            
            // JSON Columns (Menyimpan banyak data dalam 1 kolom tanpa tabel terpisah)
            $table->json('skills')->nullable(); // Array: ["Public Speaking", "Networking", "Web Dev"]
            $table->json('achievements')->nullable(); // Array of objects: [{"tahun": 2026, "nama": "Juara 1 Web"}]
            $table->json('certificates')->nullable(); 
            $table->json('committee_history')->nullable(); // Riwayat Kepanitiaan
            $table->json('board_history')->nullable(); // Riwayat Kepengurusan (Divisi & Jabatan dari tahun ke tahun)
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_profiles');
    }
};