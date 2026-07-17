<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Memanggil Seeder lain terlebih dahulu (misal: untuk membuat Role)
        $this->call([
            RoleAndAdminSeeder::class,
        ]);

        // 2. Membuat data dummy user tes jika diperlukan
        // Pastikan email ini sesuai dengan validasi domain kampus Anda jika aturan tersebut aktif
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@umku.ac.id', // Diubah agar lolos regex domain kampus umku.ac.id
        ]);
    }
}
