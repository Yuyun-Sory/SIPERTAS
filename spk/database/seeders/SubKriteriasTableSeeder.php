<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SubKriteriasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sub_kriterias')->delete();
        
        \DB::table('sub_kriterias')->insert(array (
            0 => 
            array (
                'id' => 37,
                'kriteria_id' => 4,
                'level' => 4,
                'nama' => 'Internasional / Nasional',
                'deskripsi' => 'Sangat Tinggi',
                'created_at' => '2026-05-22 13:07:42',
                'updated_at' => '2026-05-22 13:07:42',
            ),
            1 => 
            array (
                'id' => 38,
                'kriteria_id' => 4,
                'level' => 3,
                'nama' => 'Provinsi / Kab-Kota',
                'deskripsi' => 'Tinggi',
                'created_at' => '2026-05-22 13:07:42',
                'updated_at' => '2026-05-22 13:07:42',
            ),
            2 => 
            array (
                'id' => 39,
                'kriteria_id' => 4,
                'level' => 2,
                'nama' => 'Tingkat Sekolah / Kecamatan',
                'deskripsi' => 'Cukup',
                'created_at' => '2026-05-22 13:07:42',
                'updated_at' => '2026-05-22 13:07:42',
            ),
            3 => 
            array (
                'id' => 40,
                'kriteria_id' => 4,
                'level' => 1,
                'nama' => 'Tidak Ada Prestasi',
                'deskripsi' => 'Rendah',
                'created_at' => '2026-05-22 13:07:42',
                'updated_at' => '2026-05-22 13:07:42',
            ),
            4 => 
            array (
                'id' => 41,
                'kriteria_id' => 3,
                'level' => 4,
                'nama' => '90 – 100',
                'deskripsi' => 'Sangat Tinggi',
                'created_at' => '2026-05-22 13:08:42',
                'updated_at' => '2026-05-22 13:08:42',
            ),
            5 => 
            array (
                'id' => 42,
                'kriteria_id' => 3,
                'level' => 3,
                'nama' => '80 – 89',
                'deskripsi' => 'Tinggi',
                'created_at' => '2026-05-22 13:08:42',
                'updated_at' => '2026-05-22 13:08:42',
            ),
            6 => 
            array (
                'id' => 43,
                'kriteria_id' => 3,
                'level' => 2,
                'nama' => '70 – 79',
                'deskripsi' => 'Cukup',
                'created_at' => '2026-05-22 13:08:42',
                'updated_at' => '2026-05-22 13:08:42',
            ),
            7 => 
            array (
                'id' => 44,
                'kriteria_id' => 3,
                'level' => 1,
                'nama' => '< 70',
                'deskripsi' => 'Rendah',
                'created_at' => '2026-05-22 13:08:42',
                'updated_at' => '2026-05-22 13:08:42',
            ),
            8 => 
            array (
                'id' => 53,
                'kriteria_id' => 6,
                'level' => 4,
                'nama' => '96% – 100%',
                'deskripsi' => 'Sangat Tinggi',
                'created_at' => '2026-05-22 13:12:30',
                'updated_at' => '2026-05-22 13:12:30',
            ),
            9 => 
            array (
                'id' => 54,
                'kriteria_id' => 6,
                'level' => 3,
                'nama' => '86% – 95%',
                'deskripsi' => 'Tinggi',
                'created_at' => '2026-05-22 13:12:30',
                'updated_at' => '2026-05-22 13:12:30',
            ),
            10 => 
            array (
                'id' => 55,
                'kriteria_id' => 6,
                'level' => 2,
                'nama' => '75% – 85%',
                'deskripsi' => 'Cukup',
                'created_at' => '2026-05-22 13:12:30',
                'updated_at' => '2026-05-22 13:12:30',
            ),
            11 => 
            array (
                'id' => 56,
                'kriteria_id' => 6,
                'level' => 1,
                'nama' => '< 75%',
                'deskripsi' => 'Rendah',
                'created_at' => '2026-05-22 13:12:30',
                'updated_at' => '2026-05-22 13:12:30',
            ),
            12 => 
            array (
                'id' => 57,
                'kriteria_id' => 5,
                'level' => 4,
            'nama' => 'Sangat Baik (86–100)',
                'deskripsi' => 'Sangat Tinggi',
                'created_at' => '2026-06-10 11:01:28',
                'updated_at' => '2026-06-10 11:01:28',
            ),
            13 => 
            array (
                'id' => 58,
                'kriteria_id' => 5,
                'level' => 3,
            'nama' => 'Baik (71–85)',
                'deskripsi' => 'Tinggi',
                'created_at' => '2026-06-10 11:01:28',
                'updated_at' => '2026-06-10 11:01:28',
            ),
            14 => 
            array (
                'id' => 59,
                'kriteria_id' => 5,
                'level' => 2,
            'nama' => 'Cukup (56–70)',
                'deskripsi' => 'Cukup',
                'created_at' => '2026-06-10 11:01:28',
                'updated_at' => '2026-06-10 11:01:28',
            ),
            15 => 
            array (
                'id' => 60,
                'kriteria_id' => 5,
                'level' => 1,
            'nama' => 'Kurang (< 56)',
                'deskripsi' => 'Rendah',
                'created_at' => '2026-06-10 11:01:28',
                'updated_at' => '2026-06-10 11:01:28',
            ),
        ));
        
        
    }
}