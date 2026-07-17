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
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->string('source'); // Contoh: Sponsor, Dana Fakultas, Merchandise
            $table->string('description'); // Penjelasan detail
            $table->decimal('amount', 15, 2);
            $table->date('date');
            $table->foreignId('user_id')->constrained(); // Siapa yang mencatat
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
