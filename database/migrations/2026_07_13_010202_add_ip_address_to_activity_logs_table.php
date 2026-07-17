<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            // Menambahkan kolom ip_address tepat setelah kolom description
            $table->string('ip_address')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            // Membatalkan (menghapus) kolom ip_address jika migrasi di-rollback
            $table->dropColumn('ip_address');
        });
    }
};