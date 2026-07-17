<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('activity_date')->nullable();
            $table->string('division')->nullable();
            $table->text('drive_link'); // Wajib (Link Google Drive)
            $table->string('thumbnail')->nullable(); // Opsional (Sampul lokal)
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('albums');
    }
};