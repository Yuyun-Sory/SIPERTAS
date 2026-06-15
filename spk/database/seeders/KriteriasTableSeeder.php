<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class KriteriasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('kriterias')->delete();
        
        \DB::table('kriterias')->insert(array (
            0 => 
            array (
                'id' => 3,
                'kode' => 'C1',
                'nama' => 'Prestasi Akademik',
                'tipe' => 'benefit',
                'deskripsi' => 'Range Nilai Rata-rata Rapor',
                'urutan' => 1,
                'created_at' => '2026-04-22 14:21:12',
                'updated_at' => '2026-05-22 13:05:41',
            ),
            1 => 
            array (
                'id' => 4,
                'kode' => 'C2',
                'nama' => 'Prestasi Non-Akademik',
                'tipe' => 'benefit',
                'deskripsi' => 'Tingkat Prestasi',
                'urutan' => 2,
                'created_at' => '2026-04-22 14:22:17',
                'updated_at' => '2026-05-22 13:07:42',
            ),
            2 => 
            array (
                'id' => 5,
                'kode' => 'C3',
                'nama' => 'Sikap & Kepribadian',
                'tipe' => 'benefit',
            'deskripsi' => 'Nilai Sikap (Huruf / Deskripsi)',
                'urutan' => 3,
                'created_at' => '2026-04-22 14:23:06',
                'updated_at' => '2026-05-22 13:10:59',
            ),
            3 => 
            array (
                'id' => 6,
                'kode' => 'C4',
                'nama' => 'Kehadiran',
                'tipe' => 'benefit',
                'deskripsi' => NULL,
                'urutan' => 4,
                'created_at' => '2026-04-22 14:23:53',
                'updated_at' => '2026-04-22 14:23:53',
            ),
        ));
        
        
    }
}