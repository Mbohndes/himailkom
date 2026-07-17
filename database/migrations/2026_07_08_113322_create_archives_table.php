<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archives', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category');
            $table->text('drive_link')->nullable(); // TAMBAHKAN INI (Untuk link Google Drive)
            $table->string('file_path')->nullable(); // UBAH JADI NULLABLE (Boleh kosong)
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archives');
    }
};