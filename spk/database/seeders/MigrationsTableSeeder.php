<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MigrationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('migrations')->delete();
        
        \DB::table('migrations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'migration' => '0001_01_01_000000_create_users_table',
                'batch' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'migration' => '0001_01_01_000001_create_cache_table',
                'batch' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'migration' => '0001_01_01_000002_create_jobs_table',
                'batch' => 1,
            ),
            3 => 
            array (
                'id' => 4,
                'migration' => '0001_01_01_000003_create_sessions_table',
                'batch' => 1,
            ),
            4 => 
            array (
                'id' => 5,
                'migration' => '2026_04_20_130211_create_periodes_table',
                'batch' => 1,
            ),
            5 => 
            array (
                'id' => 6,
                'migration' => '2026_04_20_153253_create_kriterias_table',
                'batch' => 1,
            ),
            6 => 
            array (
                'id' => 7,
                'migration' => '2026_04_20_153315_create_sub_kriterias_table',
                'batch' => 1,
            ),
            7 => 
            array (
                'id' => 8,
                'migration' => '2026_04_21_145846_create_ahps_table',
                'batch' => 1,
            ),
            8 => 
            array (
                'id' => 9,
                'migration' => '2026_04_22_063123_create_siswas_table',
                'batch' => 1,
            ),
            9 => 
            array (
                'id' => 10,
                'migration' => '2026_04_22_063145_create_nilai_siswas_table',
                'batch' => 1,
            ),
            10 => 
            array (
                'id' => 11,
                'migration' => '2026_04_24_191724_add_kelas_to_users_table',
                'batch' => 2,
            ),
            11 => 
            array (
                'id' => 12,
                'migration' => '2026_04_25_070643_create_riwayats_table',
                'batch' => 3,
            ),
            12 => 
            array (
                'id' => 14,
                'migration' => '2026_06_03_113628_create_seleksi_siswas_table',
                'batch' => 4,
            ),
        ));
        
        
    }
}