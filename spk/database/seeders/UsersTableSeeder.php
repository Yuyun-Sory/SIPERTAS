<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => '$2y$12$xwNkKYsHLPy2YZKb.Z4kuewGYMo3nOCTgV8dBuu5gw872bp/7Xfce',
                'role' => 'admin',
                'kelas' => NULL,
                'is_active' => 1,
                'remember_token' => 'tgrJCXbv2zBV8FlZXIdC52QrxPDbWmIZmmfpuTYwlB5fX2ku8MHgXyXwDwvT',
                'created_at' => '2026-04-22 06:46:25',
                'updated_at' => '2026-05-18 08:40:20',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Maria Yuyun Sory',
                'username' => 'Yuyun',
                'email' => 'yuyunsory@gmail.com',
                'password' => '$2y$12$Ox8.nxejFQGVvftgSRVso.C5.XIeKLvu0Lhct5eAKSncNkg/PFcwK',
                'role' => 'wali_kelas',
                'kelas' => 'VIII A',
                'is_active' => 1,
                'remember_token' => NULL,
                'created_at' => '2026-04-25 12:34:46',
                'updated_at' => '2026-06-04 13:21:47',
            ),
            2 => 
            array (
                'id' => 4,
                'name' => 'Carenita',
                'username' => 'Carenita',
                'email' => 'carenita@gmail.com',
                'password' => '$2y$12$y5PQch/V2fuNMcAQCSQsh.yR0Agl2JjNjLa5t4IHYgySeT53vrKfW',
                'role' => 'kepala_sekolah',
                'kelas' => NULL,
                'is_active' => 1,
                'remember_token' => NULL,
                'created_at' => '2026-05-26 12:42:17',
                'updated_at' => '2026-05-26 12:42:17',
            ),
            3 => 
            array (
                'id' => 5,
                'name' => 'syalal',
                'username' => 'saya',
                'email' => 'saya@gmail.com',
                'password' => '$2y$12$rpkn/UBHSWyE8e51biVJQe1ItkwPOWzu.gS5ZQXIWR.FVIJTlOsMu',
                'role' => 'wali_kelas',
                'kelas' => 'VII A',
                'is_active' => 1,
                'remember_token' => NULL,
                'created_at' => '2026-06-07 15:40:10',
                'updated_at' => '2026-06-07 15:43:00',
            ),
        ));
        
        
    }
}