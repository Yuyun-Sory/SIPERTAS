<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SiswasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('siswas')->delete();
        
        \DB::table('siswas')->insert(array (
            0 => 
            array (
                'id' => 14,
                'nis' => '567890',
                'nama' => 'Apriliius Alexandro Uku',
                'kelas' => 'VII A',
                'jenis_kelamin' => 'L',
                'foto' => NULL,
                'is_active' => 1,
                'created_at' => '2026-05-26 20:03:41',
                'updated_at' => '2026-05-26 20:03:41',
            ),
            1 => 
            array (
                'id' => 15,
                'nis' => '34567897',
                'nama' => 'Clarita Dhiu Tara Kopa',
                'kelas' => 'VII A',
                'jenis_kelamin' => 'P',
                'foto' => NULL,
                'is_active' => 1,
                'created_at' => '2026-05-26 20:04:16',
                'updated_at' => '2026-05-26 20:04:16',
            ),
            2 => 
            array (
                'id' => 16,
                'nis' => '123456',
                'nama' => 'Alexandro Sergio Hasa',
                'kelas' => 'VII B',
                'jenis_kelamin' => 'L',
                'foto' => NULL,
                'is_active' => 1,
                'created_at' => '2026-05-26 20:07:04',
                'updated_at' => '2026-05-26 20:07:04',
            ),
            3 => 
            array (
                'id' => 17,
                'nis' => '2345678',
                'nama' => 'Alpamanius Jogo',
                'kelas' => 'VII B',
                'jenis_kelamin' => 'L',
                'foto' => NULL,
                'is_active' => 1,
                'created_at' => '2026-05-26 20:07:38',
                'updated_at' => '2026-05-26 20:07:38',
            ),
            4 => 
            array (
                'id' => 18,
                'nis' => '897755',
                'nama' => 'Anastasia Kune Narek',
                'kelas' => 'VII B',
                'jenis_kelamin' => 'P',
                'foto' => NULL,
                'is_active' => 1,
                'created_at' => '2026-05-26 20:08:57',
                'updated_at' => '2026-05-26 20:08:57',
            ),
            5 => 
            array (
                'id' => 19,
                'nis' => '45678901',
                'nama' => 'Kornelis Velson Pati Lela Ona',
                'kelas' => 'VII A',
                'jenis_kelamin' => 'L',
                'foto' => NULL,
                'is_active' => 1,
                'created_at' => '2026-05-29 18:11:35',
                'updated_at' => '2026-05-29 18:11:35',
            ),
            6 => 
            array (
                'id' => 20,
                'nis' => '0986325',
                'nama' => 'Balduinus Reo',
                'kelas' => 'VII A',
                'jenis_kelamin' => 'L',
                'foto' => NULL,
                'is_active' => 1,
                'created_at' => '2026-06-04 13:07:12',
                'updated_at' => '2026-06-04 13:07:12',
            ),
            7 => 
            array (
                'id' => 21,
                'nis' => '098765432',
                'nama' => 'Marsela Anggi Dhengi',
                'kelas' => 'VII A',
                'jenis_kelamin' => 'L',
                'foto' => NULL,
                'is_active' => 1,
                'created_at' => '2026-06-06 10:39:55',
                'updated_at' => '2026-06-06 10:39:55',
            ),
            8 => 
            array (
                'id' => 22,
                'nis' => '74857363',
                'nama' => 'hsdfdjryhbfj',
                'kelas' => 'VII A',
                'jenis_kelamin' => 'L',
                'foto' => NULL,
                'is_active' => 1,
                'created_at' => '2026-06-11 13:54:40',
                'updated_at' => '2026-06-11 13:54:40',
            ),
        ));
        
        
    }
}