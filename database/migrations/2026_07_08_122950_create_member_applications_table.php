<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nim')->unique();
            $table->string('email')->unique(); // Untuk penampung Email Kampus
            $table->string('study_program');
            $table->string('cohort'); // Angkatan
            $table->string('phone');
            
            // Progres Verifikasi Berjenjang
            $table->enum('status', ['Terdaftar', 'Menunggu Verifikasi', 'Ditolak', 'Perlu Revisi Data', 'Disetujui'])->default('Terdaftar');
            $table->text('admin_notes')->nullable(); // Keterangan jika ditolak / perlu revisi
            
            // Kolom Penempatan (Diisi saat Admin melakukan Verifikasi Terima)
            $table->foreignId('division_id')->nullable()->constrained('divisions')->nullOnDelete();
            $table->foreignId('period_id')->nullable()->constrained('periods')->nullOnDelete();
            $table->string('assigned_role')->nullable(); // Contoh: 'Pengurus', 'Anggota'
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_applications');
    }
};