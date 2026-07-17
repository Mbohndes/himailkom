<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Perhatikan ini menggunakan Schema::create, BUKAN Schema::table
        Schema::create('periods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: Periode 2026/2027
            $table->year('start_year')->nullable();
            $table->year('end_year')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            
            $table->enum('status', ['Aktif', 'Arsip', 'Persiapan'])->default('Persiapan');
            
            $table->string('theme')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periods');
    }
};