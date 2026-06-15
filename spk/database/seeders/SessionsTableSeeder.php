<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SessionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sessions')->delete();
        
        \DB::table('sessions')->insert(array (
            0 => 
            array (
                'id' => '3GeIsDbWAPhIQrsEpBJCiLCsnqh3LGn4ZJ6AtSb2',
                'user_id' => 4,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36',
                'payload' => 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiV0FRck1vQ3RGZm14dzUwbE1ydFFIUmZQYlkxTVdRbUhUUlpCTVZYQSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3NtYXJ0Ijt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zbWFydCI7czo1OiJyb3V0ZSI7czoxMToic21hcnQuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=',
                'last_activity' => 1781162168,
            ),
            1 => 
            array (
                'id' => 'pJXbpDoKwavqkvLbRDJAwjEs4HQ8u2oY5ruC9V73',
                'user_id' => 1,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0',
                'payload' => 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoickJ4WTFVbjlWbGw0dkdJMlNJT1ZvWlh0a3FMNkRUa1NpcE12QUg3cyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zaXN3YSI7czo1OiJyb3V0ZSI7czoxMToic2lzd2EuaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=',
                'last_activity' => 1781170470,
            ),
            2 => 
            array (
                'id' => 'Su3mIuBH7Ue2TaCUUZY1FpRRlX833rCfPcYX2Den',
                'user_id' => 5,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36',
                'payload' => 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiR1g2em1Qc1dvSVd6ZDZXZWRVYTNoeWFSS0p4TVhDeDBiS2VNdVJBVyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9uaWxhaS8xNS9lZGl0P3BlcmlvZGVfaWQ9NyI7czo1OiJyb3V0ZSI7czoxMDoibmlsYWkuZWRpdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==',
                'last_activity' => 1781161749,
            ),
            3 => 
            array (
                'id' => 'zfrBm0cU6l3SudZO5y5P9NEr09XSJ8rrOegh0NEb',
                'user_id' => NULL,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0',
                'payload' => 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaXJ0djZWMWRqQTJvYWhZbTF5azhpREl2emx4VGM0d3NpVjZmTExETiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=',
                'last_activity' => 1781512526,
            ),
        ));
        
        
    }
}