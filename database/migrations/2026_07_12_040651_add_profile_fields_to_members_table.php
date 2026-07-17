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
        Schema::table('members', function (Blueprint $table) {
            // Menambahkan kolom baru jika belum ada
            if (!Schema::hasColumn('members', 'emergency_contact')) {
                $table->string('emergency_contact')->nullable()->after('nim');
            }
            if (!Schema::hasColumn('members', 'skills')) {
                $table->text('skills')->nullable()->after('emergency_contact');
            }
            if (!Schema::hasColumn('members', 'achievements')) {
                $table->text('achievements')->nullable()->after('skills');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['emergency_contact', 'skills', 'achievements']);
        });
    }
};