<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleAndAdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Role Super Admin
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);

        // 2. Buat Akun Kredensial (Hanya untuk Login di tabel users)
        $adminUser = User::firstOrCreate(
            ['email' => 'riski@student.umku.ac.id'],
            [
                'name' => 'Riski Kurniawan',
                'password' => Hash::make('password123'),
            ]
        );

        // Berikan Role ke User
        $adminUser->assignRole($superAdminRole);

        // 3. Buat Master Data Dasar (Syarat wajib untuk tabel members)
        $period = DB::table('periods')->insertGetId([
            'name' => '2025/2026',
            'start_date' => '2025-01-01',
            'end_date' => '2026-12-31',
            'is_active' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $position = DB::table('positions')->insertGetId([
            'name' => 'Super Admin',
            'hierarchy_level' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // 4. Masukkan Profil Anggota ke Tabel Members (Relasi 3NF)
        DB::table('members')->updateOrInsert(
            ['nim' => '0000000001'], // Ganti dengan NIM asli Anda jika perlu
            [
                'user_id' => $adminUser->id,
                'full_name' => 'Riski Kurniawan',
                'gender' => 'L',
                'study_program' => 'Ilmu Komputer',
                'generation' => 2024,
                'period_id' => $period,
                'position_id' => $position,
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
    }
}