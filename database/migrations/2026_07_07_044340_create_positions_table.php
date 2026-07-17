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
    Schema::create('positions', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique(); // Ketua, Bendahara, Anggota Biasa
        $table->integer('hierarchy_level')->default(99); // Untuk urutan struktur (1 = Ketua, 2 = Wakil, dst)
        $table->timestamps();
        $table->softDeletes();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
