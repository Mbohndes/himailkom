<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Data Agenda Utama
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id')->constrained()->restrictOnDelete();
            $table->string('title');
            $table->enum('category', ['Rapat', 'Musyawarah', 'Evaluasi', 'Lainnya'])->default('Rapat');
            $table->dateTime('date_time');
            $table->string('location');
            $table->foreignId('pic_id')->constrained('users')->restrictOnDelete();
            $table->enum('status', ['Terjadwal', 'Berlangsung', 'Selesai', 'Dibatalkan'])->default('Terjadwal');
            $table->text('notes')->nullable();
            $table->string('attachment')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Tabel Absensi / Kehadiran Peserta
        Schema::create('agenda_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agenda_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['Hadir', 'Izin', 'Sakit', 'Alfa', 'Belum Absen'])->default('Belum Absen');
            $table->string('reason')->nullable(); // Alasan jika Izin/Sakit
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agenda_attendances');
        Schema::dropIfExists('agendas');
    }
};