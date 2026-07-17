<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prokers', function (Blueprint $table) {
            $table->id();
            $table->string('program_code')->unique(); // Kode Program (misal: PK-KOM-001)
            $table->string('name');
            
            // Relasi (Foreign Keys)
            $table->foreignId('division_id')->constrained()->restrictOnDelete();
            $table->foreignId('period_id')->constrained()->restrictOnDelete();
            // PIC (Ketua Pelaksana & Wakil) dihubungkan ke tabel users untuk hak akses sistem
            $table->foreignId('pic_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('vice_pic_id')->nullable()->constrained('users')->nullOnDelete();

            // Detail Proker
            $table->text('description')->nullable();
            $table->text('objective')->nullable(); // Tujuan
            $table->text('target')->nullable(); // Target pencapaian
            $table->string('location')->nullable();
            
            // Waktu
            $table->date('start_date');
            $table->date('end_date');
            
            // Status & Kategori
            $table->enum('status', ['Draft', 'Berjalan', 'Selesai', 'Terlambat', 'Dibatalkan'])->default('Draft');
            $table->enum('priority', ['Rendah', 'Sedang', 'Tinggi'])->default('Sedang');
            $table->string('program_type'); // Jenis Program (Seminar, Pelatihan, dll)
            
            // Angka & Finansial
            $table->integer('estimated_participants')->default(0);
            $table->decimal('budget_planned', 15, 2)->default(0); // Anggaran
            $table->decimal('budget_realized', 15, 2)->default(0); // Realisasi
            $table->unsignedTinyInteger('progress_percentage')->default(0);
            
            // Opsional
            $table->string('sponsors')->nullable(); // Bisa juga dibuat tabel terpisah nanti jika kompleks
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prokers');
    }
};