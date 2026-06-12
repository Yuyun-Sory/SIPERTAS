<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'kode'      => 'C1',
                'nama'      => 'Sikap dan Perilaku',
                'tipe'      => 'benefit',
                'deskripsi' => 'Penilaian berdasarkan perilaku dan kepatuhan siswa terhadap peraturan sekolah.',
                'urutan'    => 1,
                'subs' => [
                    ['level' => 4, 'nama' => 'Sangat Baik', 'deskripsi' => 'Sopan, taat aturan, tidak ada poin pelanggaran'],
                    ['level' => 3, 'nama' => 'Baik',        'deskripsi' => 'Sopan, taat aturan, ada 1-2 poin pelanggaran ringan'],
                    ['level' => 2, 'nama' => 'Cukup',       'deskripsi' => 'Kadang melanggar aturan, perilaku standar'],
                    ['level' => 1, 'nama' => 'Kurang',      'deskripsi' => 'Sering melanggar aturan / mendapat teguran'],
                ],
            ],
            [
                'kode'      => 'C2',
                'nama'      => 'Siswa Berprestasi',
                'tipe'      => 'benefit',
                'deskripsi' => 'Penilaian berdasarkan rata-rata rapor dan prestasi akademik/non-akademik siswa.',
                'urutan'    => 2,
                'subs' => [
                    ['level' => 4, 'nama' => 'Sangat Baik', 'deskripsi' => 'Rata-rata Rapor ≥ 90 atau Juara 1-3 (Kabupaten/Provinsi)'],
                    ['level' => 3, 'nama' => 'Baik',        'deskripsi' => 'Rata-rata Rapor 80-89 atau Juara 1-3 (Tingkat Sekolah)'],
                    ['level' => 2, 'nama' => 'Cukup',       'deskripsi' => 'Rata-rata Rapor 75-79 atau Aktif berorganisasi'],
                    ['level' => 1, 'nama' => 'Kurang',      'deskripsi' => 'Rata-rata Rapor < 75 dan tidak ada prestasi tambahan'],
                ],
            ],
            [
                'kode'      => 'C3',
                'nama'      => 'Datang Tepat Waktu',
                'tipe'      => 'benefit',
                'deskripsi' => 'Tingkat kedisiplinan siswa dalam hal ketepatan waktu kehadiran di sekolah.',
                'urutan'    => 3,
                'subs' => [
                    ['level' => 4, 'nama' => 'Sangat Baik', 'deskripsi' => 'Tidak pernah terlambat dalam 1 semester'],
                    ['level' => 3, 'nama' => 'Baik',        'deskripsi' => 'Terlambat 1-3 kali dalam 1 semester'],
                    ['level' => 2, 'nama' => 'Cukup',       'deskripsi' => 'Terlambat 4-7 kali dalam 1 semester'],
                    ['level' => 1, 'nama' => 'Kurang',      'deskripsi' => 'Terlambat lebih dari 7 kali dalam 1 semester'],
                ],
            ],
            [
                'kode'      => 'C4',
                'nama'      => 'Kehadiran',
                'tipe'      => 'benefit',
                'deskripsi' => 'Persentase kehadiran siswa selama 1 semester penuh.',
                'urutan'    => 4,
                'subs' => [
                    ['level' => 4, 'nama' => 'Sangat Baik', 'deskripsi' => 'Kehadiran ≥ 95%'],
                    ['level' => 3, 'nama' => 'Baik',        'deskripsi' => 'Kehadiran 85% - 94%'],
                    ['level' => 2, 'nama' => 'Cukup',       'deskripsi' => 'Kehadiran 75% - 84%'],
                    ['level' => 1, 'nama' => 'Kurang',      'deskripsi' => 'Kehadiran < 75%'],
                ],
            ],
            [
                'kode'      => 'C5',
                'nama'      => 'Aktif Organisasi',
                'tipe'      => 'benefit',
                'deskripsi' => 'Keterlibatan siswa dalam kegiatan organisasi intra sekolah (OSIS, ekskul, dsb).',
                'urutan'    => 5,
                'subs' => [
                    ['level' => 4, 'nama' => 'Sangat Aktif', 'deskripsi' => 'Pengurus inti OSIS / ketua ekskul aktif'],
                    ['level' => 3, 'nama' => 'Aktif',        'deskripsi' => 'Anggota aktif minimal 2 organisasi'],
                    ['level' => 2, 'nama' => 'Cukup',        'deskripsi' => 'Tergabung dalam 1 organisasi'],
                    ['level' => 1, 'nama' => 'Tidak Aktif',  'deskripsi' => 'Tidak mengikuti organisasi apapun'],
                ],
            ],
            [
                'kode'      => 'C6',
                'nama'      => 'Kemampuan Sosial',
                'tipe'      => 'benefit',
                'deskripsi' => 'Penilaian kemampuan berinteraksi dan berkontribusi dalam lingkungan sosial sekolah.',
                'urutan'    => 6,
                'subs' => [
                    ['level' => 4, 'nama' => 'Sangat Baik', 'deskripsi' => 'Mudah bergaul, sering membantu teman, punya jiwa kepemimpinan'],
                    ['level' => 3, 'nama' => 'Baik',        'deskripsi' => 'Bergaul dengan baik, kadang membantu teman'],
                    ['level' => 2, 'nama' => 'Cukup',       'deskripsi' => 'Cukup bergaul, tidak terlalu menonjol'],
                    ['level' => 1, 'nama' => 'Kurang',      'deskripsi' => 'Sulit bergaul atau sering konflik dengan teman'],
                ],
            ],
        ];

        foreach ($data as $item) {
            $subs = $item['subs'];
            unset($item['subs']);

            $kriteria = Kriteria::create($item);

            foreach ($subs as $sub) {
                SubKriteria::create(array_merge($sub, ['kriteria_id' => $kriteria->id]));
            }
        }
    }
}
