<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('member_profiles', function (Blueprint $table) {
            $table->year('entry_year')->nullable()->after('phone_emergency'); // Tahun Masuk
            $table->year('graduation_year')->nullable()->after('entry_year'); // Tahun Lulus
            $table->string('workplace')->nullable()->after('graduation_year'); // Tempat Kerja saat ini
            $table->string('linkedin_url')->nullable()->after('workplace'); // Link LinkedIn
            $table->text('contribution')->nullable()->after('linkedin_url'); // Catatan Kontribusi
        });
    }

    public function down(): void
    {
        Schema::table('member_profiles', function (Blueprint $table) {
            $table->dropColumn(['entry_year', 'graduation_year', 'workplace', 'linkedin_url', 'contribution']);
        });
    }
};