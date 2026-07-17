<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom jika belum ada
            if (!Schema::hasColumn('users', 'nim')) {
                $table->string('nim')->nullable()->unique()->after('email');
            }
            if (!Schema::hasColumn('users', 'photo')) {
                $table->string('photo')->nullable()->after('nim');
            }
            if (!Schema::hasColumn('users', 'position')) {
                $table->string('position')->nullable()->after('photo'); // Jabatan (Ketua, Kadiv, Staff, dll)
            }
            if (!Schema::hasColumn('users', 'status')) {
                $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif')->after('position');
            }
            if (!Schema::hasColumn('users', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable()->after('remember_token');
            }
            
            // Relasi Penempatan (Jika belum ada dari migrasi sebelumnya)
            if (!Schema::hasColumn('users', 'division_id')) {
                $table->foreignId('division_id')->nullable()->constrained('divisions')->nullOnDelete();
            }
            if (!Schema::hasColumn('users', 'period_id')) {
                $table->foreignId('period_id')->nullable()->constrained('periods')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nim', 'photo', 'position', 'status', 'last_login_at']);
            // Drop foreign keys if necessary
        });
    }
};