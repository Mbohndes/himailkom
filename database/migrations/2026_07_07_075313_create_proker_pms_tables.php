<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. STRUKTUR PANITIA (Kebutuhan & Kuota Divisi Kepanitiaan)
        Schema::create('proker_committees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proker_id')->constrained()->cascadeOnDelete();
            $table->string('role_name'); // Contoh: "Divisi Acara", "Sekretaris"
            $table->integer('quota')->default(1); // Jumlah orang yang dibutuhkan
            $table->timestamps();
        });

        // 2. ANGGOTA PANITIA (Pemenuhan Kuota dari Data Members)
        Schema::create('proker_committee_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proker_committee_id')->constrained('proker_committees')->cascadeOnDelete();
            // Mengambil dari tabel users/members (gunakan users agar bisa login & punya dashboard tugas)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); 
            $table->timestamps();
        });

        // 3. WORKFLOW / TAHAPAN (Kolom-kolom Kanban)
        Schema::create('proker_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proker_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // Contoh: "Persiapan", "Pelaksanaan", "LPJ"
            $table->integer('order_index'); // Untuk fitur Drag & Drop urutan tahapan
            $table->date('deadline')->nullable();
            $table->foreignId('pic_id')->nullable()->constrained('users')->nullOnDelete(); // Penanggung jawab tahapan
            $table->enum('status', ['Pending', 'Berjalan', 'Selesai', 'Terlambat'])->default('Pending');
            $table->timestamps();
            $table->softDeletes();
        });

        // 4. TASK MANAGEMENT (Kartu Tugas / Checklist)
        Schema::create('proker_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proker_stage_id')->constrained('proker_stages')->cascadeOnDelete();
            // Self-referencing foreign key untuk fitur SUB-TASK
            $table->foreignId('parent_task_id')->nullable()->constrained('proker_tasks')->cascadeOnDelete(); 
            
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('deadline')->nullable();
            $table->enum('priority', ['Rendah', 'Sedang', 'Tinggi', 'Mendesak'])->default('Sedang');
            $table->enum('status', ['Belum Dimulai', 'Berjalan', 'Selesai', 'Ditunda'])->default('Belum Dimulai');
            $table->unsignedTinyInteger('progress')->default(0); // 0-100%
            
            $table->timestamps();
            $table->softDeletes();
        });

        // 5. PENUGASAN ANGGOTA (Bisa lebih dari 1 orang per Task)
        Schema::create('proker_task_assignees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proker_task_id')->constrained('proker_tasks')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Anggota yang mengerjakan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proker_task_assignees');
        Schema::dropIfExists('proker_tasks');
        Schema::dropIfExists('proker_stages');
        Schema::dropIfExists('proker_committee_members');
        Schema::dropIfExists('proker_committees');
    }
};