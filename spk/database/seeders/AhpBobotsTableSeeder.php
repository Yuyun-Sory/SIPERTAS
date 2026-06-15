<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AhpBobotsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ahp_bobots')->delete();
        
        \DB::table('ahp_bobots')->insert(array (
            0 => 
            array (
                'id' => 1,
                'kriteria_id' => 3,
                'bobot' => '0.37974034',
                'matrix_json' => '[[1,2,2,2],[0.5,1,2,3],[0.5,0.5,1,3],[0.5,0.3333333333,0.3333333333,1]]',
                'created_at' => '2026-06-08 15:48:48',
                'updated_at' => '2026-06-08 15:48:48',
            ),
            1 => 
            array (
                'id' => 2,
                'kriteria_id' => 4,
                'bobot' => '0.29230072',
                'matrix_json' => NULL,
                'created_at' => '2026-06-08 15:48:48',
                'updated_at' => '2026-06-08 15:48:48',
            ),
            2 => 
            array (
                'id' => 3,
                'kriteria_id' => 5,
                'bobot' => '0.21281703',
                'matrix_json' => NULL,
                'created_at' => '2026-06-08 15:48:48',
                'updated_at' => '2026-06-08 15:48:48',
            ),
            3 => 
            array (
                'id' => 4,
                'kriteria_id' => 6,
                'bobot' => '0.11514191',
                'matrix_json' => NULL,
                'created_at' => '2026-06-08 15:48:48',
                'updated_at' => '2026-06-08 15:48:48',
            ),
        ));
        
        
    }
}