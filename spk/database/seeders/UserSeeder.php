<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'      => 'Administrator',
                'username'  => 'admin',
                'email'     => 'admin@spk.com',
                'password'  => Hash::make('admin123'),
                'role'      => 'admin',
                'is_active' => true,
            ],
            [
                'name'      => 'Budi Santoso',
                'username'  => 'guru01',
                'email'     => 'guru@spk.com',
                'password'  => Hash::make('guru123'),
                'role'      => 'guru',
                'is_active' => true,
            ],
            [
                'name'      => 'Dr. Siti Rahayu',
                'username'  => 'kepsek',
                'email'     => 'kepsek@spk.com',
                'password'  => Hash::make('kepsek123'),
                'role'      => 'kepala_sekolah',
                'is_active' => true,
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['username' => $user['username']],
                $user
            );
        }

        $this->command->info('✅ User seeder berhasil dijalankan!');
        $this->command->table(
            ['Role', 'Username', 'Password'],
            [
                ['Admin',          'admin',   'admin123'],
                ['Guru',           'guru01',  'guru123'],
                ['Kepala Sekolah', 'kepsek',  'kepsek123'],
            ]
        );
    }
}