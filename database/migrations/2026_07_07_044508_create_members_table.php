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
    Schema::create('members', function (Blueprint $table) {
        $table->id();
        // Relasi ke Akun Login
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        
        // Data Pribadi & Akademik
        $table->string('nim', 20)->unique();
        $table->string('full_name');
        $table->enum('gender', ['L', 'P']);
        $table->string('place_of_birth')->nullable();
        $table->date('date_of_birth')->nullable();
        $table->text('address')->nullable();
        $table->string('phone_number', 20)->nullable();
        $table->string('study_program')->default('Ilmu Komputer');
        $table->year('generation'); // Angkatan
        
        // Relasi Struktural (Organisasi saat ini)
        $table->foreignId('period_id')->constrained()->restrictOnDelete();
        $table->foreignId('division_id')->nullable()->constrained()->nullOnDelete();
        $table->foreignId('position_id')->constrained()->restrictOnDelete();
        
        // Status & Media
        $table->enum('status', ['Aktif', 'Non Aktif', 'Lulus', 'DO', 'Pindah'])->default('Aktif');
        $table->string('photo_path')->nullable();
        
        // JSON Fields untuk data yang bersifat dinamis (Skills, Prestasi)
        $table->json('skills')->nullable();
        $table->json('achievements')->nullable();
        $table->json('committee_history')->nullable(); // Riwayat Kepanitiaan
        $table->json('management_history')->nullable(); // Riwayat Kepengurusan
        
        $table->timestamps();
        $table->softDeletes();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
