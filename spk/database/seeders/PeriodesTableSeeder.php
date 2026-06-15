<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PeriodesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('periodes')->delete();
        
        \DB::table('periodes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nama_periode' => 'Tahun ajaran Ganjil 2025',
                'tanggal_mulai' => '2026-04-20',
                'tanggal_selesai' => '2026-04-24',
                'status' => 'nonaktif',
                'keterangan' => '2345678',
                'created_at' => '2026-04-22 10:22:42',
                'updated_at' => '2026-04-22 13:34:19',
            ),
            1 => 
            array (
                'id' => 2,
                'nama_periode' => '2026',
                'tanggal_mulai' => '2026-04-23',
                'tanggal_selesai' => '2026-04-30',
                'status' => 'nonaktif',
                'keterangan' => 'hallo',
                'created_at' => '2026-04-22 13:34:19',
                'updated_at' => '2026-05-26 19:11:51',
            ),
            2 => 
            array (
                'id' => 3,
                'nama_periode' => 'Tahun Ajaran Baru Juni',
                'tanggal_mulai' => '2026-05-27',
                'tanggal_selesai' => '2026-06-07',
                'status' => 'nonaktif',
                'keterangan' => 'Ajaran 2026',
                'created_at' => '2026-05-26 19:11:51',
                'updated_at' => '2026-06-04 11:32:39',
            ),
            3 => 
            array (
                'id' => 4,
                'nama_periode' => 'Tahun apa saja',
                'tanggal_mulai' => '2026-06-04',
                'tanggal_selesai' => '2026-06-11',
                'status' => 'nonaktif',
                'keterangan' => 'ajaran baru',
                'created_at' => '2026-06-04 11:32:39',
                'updated_at' => '2026-06-05 11:39:03',
            ),
            4 => 
            array (
                'id' => 5,
                'nama_periode' => 'asfghjkl;',
                'tanggal_mulai' => '2026-06-05',
                'tanggal_selesai' => '2026-06-07',
                'status' => 'nonaktif',
                'keterangan' => 'dfghjkl;',
                'created_at' => '2026-06-05 11:39:03',
                'updated_at' => '2026-06-07 08:59:45',
            ),
            5 => 
            array (
                'id' => 6,
                'nama_periode' => 'kepsek liburan',
                'tanggal_mulai' => '2026-06-07',
                'tanggal_selesai' => '2026-06-10',
                'status' => 'nonaktif',
                'keterangan' => 'yeahhh',
                'created_at' => '2026-06-07 08:59:45',
                'updated_at' => '2026-06-09 02:43:29',
            ),
            6 => 
            array (
                'id' => 7,
                'nama_periode' => '123456789',
                'tanggal_mulai' => '2026-06-10',
                'tanggal_selesai' => '2026-06-13',
                'status' => 'aktif',
                'keterangan' => 'sdfghnjmk,l',
                'created_at' => '2026-06-09 02:43:29',
                'updated_at' => '2026-06-09 02:43:29',
            ),
        ));
        
        
    }
}