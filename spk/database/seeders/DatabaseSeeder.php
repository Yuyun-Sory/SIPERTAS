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
        // 1. Jalankan data Master / Tabel Induk terlebih dahulu
        $this->call(PeriodesTableSeeder::class);
        $this->call(KriteriasTableSeeder::class);
        
        // Buat user admin default
        User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);
        $this->call(UsersTableSeeder::class); // Seeder user tambahan dari phpMyAdmin (jika ada)

        // 2. Jalankan data Tabel Anak yang bergantung pada Kriteria/Periode/User
        $this->call(SubKriteriasTableSeeder::class);
        $this->call(SiswasTableSeeder::class);
        $this->call(AhpBobotsTableSeeder::class); // Sekarang aman karena Kriterias sudah diisi duluan
        $this->call(NilaiSiswasTableSeeder::class);
        $this->call(RiwayatsTableSeeder::class);

        // 3. Jalankan data sistem pendukung (Opsional, bawaan Laravel)
        $this->call(CacheTableSeeder::class);
        $this->call(CacheLocksTableSeeder::class);
        $this->call(FailedJobsTableSeeder::class);
        $this->call(JobBatchesTableSeeder::class);
        $this->call(JobsTableSeeder::class);
        $this->call(SessionsTableSeeder::class);
        
        // Catatan: MigrationsTableSeeder sengaja dihilangkan agar tidak bentrok
    }
}
