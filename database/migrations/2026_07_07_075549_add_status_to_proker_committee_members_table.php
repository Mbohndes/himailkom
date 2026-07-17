<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proker_committee_members', function (Blueprint $table) {
            // Jika BPH yang input otomatis 'Disetujui', jika Kadiv yang mengusulkan statusnya 'Pending'
            $table->enum('status', ['Pending', 'Disetujui'])->default('Disetujui')->after('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('proker_committee_members', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};