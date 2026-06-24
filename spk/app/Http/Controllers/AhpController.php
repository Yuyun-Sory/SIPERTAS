<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Ahp;
use App\Models\Riwayat;
use Illuminate\Http\Request;

class AhpController extends Controller
{
    /**
     * Random Index (RI) Saaty
     */
    private array $ri = [
        1  => 0.00,
        2  => 0.00,
        3  => 0.58,
        4  => 0.90,
        5  => 1.12,
        6  => 1.24,
        7  => 1.32,
        8  => 1.41,
        9  => 1.45,
        10 => 1.49,
        11 => 1.51,
        12 => 1.48,
        13 => 1.56,
        14 => 1.57,
        15 => 1.59,
    ];

    /**
     * Halaman AHP
     */
    public function index()
    {
        $kriterias = Kriteria::orderBy('urutan')->get();
        $n         = $kriterias->count();
        $ri        = $this->ri;

        $matrix         = [];
        $hasil          = null;
        $bobotTersimpan = false;

        $ahpRecord = Ahp::whereNotNull('matrix_json')->first();

        if ($ahpRecord && $ahpRecord->matrix_json) {
            $decoded = json_decode($ahpRecord->matrix_json, true);

            if (is_array($decoded) && count($decoded) === $n) {
                $matrix         = $decoded;
                $hasil          = $this->hitungAHP($matrix, $kriterias);
                $bobotTersimpan = true;
            }
        }

        $savedBobots = Ahp::all()->keyBy('kriteria_id');

        return view('ahp.index', compact(
            'kriterias',
            'n',
            'ri',
            'matrix',
            'hasil',
            'savedBobots',
            'bobotTersimpan'
        ));
    }

    /**
     * Hitung & Simpan AHP
     */
    public function hitung(Request $request)
    {
        $kriterias = Kriteria::orderBy('urutan')->get();
        $n         = $kriterias->count();

        if ($n < 2) {
            return redirect()
                ->route('ahp.index')
                ->with('error', 'AHP membutuhkan minimal 2 kriteria.');
        }

        $request->validate([
            'matrix' => 'required|array',
        ]);

        $rawMatrix = $request->input('matrix', []);

        // Bangun matriks simetris lengkap
        $matrix = array_fill(0, $n, array_fill(0, $n, 1.0));

        for ($i = 0; $i < $n; $i++) {
            for ($j = $i + 1; $j < $n; $j++) {
                $value = $this->parseMatrixValue(
                    $rawMatrix[$i][$j] ?? '1'
                );

                if ($value <= 0) {
                    $value = 1.0;
                }

                $matrix[$i][$j] = $value;
                $matrix[$j][$i] = round(1 / $value, 10);
            }
        }

        $hasil = $this->hitungAHP($matrix, $kriterias);

        // Tolak jika tidak konsisten
        if (! $hasil['consistent']) {
            return redirect()
                ->route('ahp.index')
                ->with(
                    'error',
                    'Matriks tidak konsisten. CR = ' .
                    number_format($hasil['cr'], 4) .
                    ' (harus ≤ 0,10). Silakan revisi nilai perbandingan.'
                );
        }

        /**
         * =====================================================
         * SIMPAN BOBOT TERBARU (BUKAN HISTORI)
         * =====================================================
         */
        Ahp::truncate();

        foreach ($kriterias as $index => $kriteria) {
            Ahp::create([
                'kriteria_id' => $kriteria->id,
                'bobot'       => $hasil['bobot'][$index],
                'matrix_json' => $index === 0
                    ? json_encode($matrix)
                    : null,
            ]);
        }

        /**
         * =====================================================
         * SIMPAN RIWAYAT AHP — data LENGKAP untuk laporan
         * (kode/nama/tipe kriteria + seluruh langkah hitungan)
         * =====================================================
         */
        $kriteriaInfo = $kriterias->map(function ($k) {
            return [
                'id'   => $k->id,
                'kode' => $k->kode,
                'nama' => $k->nama,
                'tipe' => $k->tipe,
            ];
        })->values()->toArray();

        Riwayat::create([
            'jenis'      => 'ahp',
            'periode_id' => null,
            'user_id'    => auth()->id(),
            'judul'      => 'Perhitungan AHP - ' . now()->format('d M Y H:i'),
            'data_json'  => [
                'kriteria'     => $kriteriaInfo,
                'matrix'       => $matrix,
                'colSum'       => $hasil['colSum'],
                'norm'         => $hasil['norm'],
                'rowNorm'      => $hasil['rowNorm'],
                'bobot'        => $hasil['bobot'],
                'matTimesW'    => $hasil['matTimesW'],
                'lambdaValues' => $hasil['lambdaValues'],
                'lambdaMax'    => $hasil['lambdaMax'],
                'ci'           => $hasil['ci'],
                'ri'           => $hasil['ri'],
                'cr'           => $hasil['cr'],
                'consistent'   => $hasil['consistent'],
                'n'            => $hasil['n'],
            ],
        ]);

        return redirect()
            ->route('ahp.index')
            ->with(
                'success',
                'Bobot AHP berhasil disimpan! CR = ' .
                number_format($hasil['cr'], 4) .
                ' ✅ Konsisten'
            );
    }

    /**
     * Parse nilai dari input form.
     * Mendukung: "3", "1/3", "0.333", dst.
     */
    private function parseMatrixValue(mixed $raw): float
    {
        if (is_numeric($raw)) {
            return (float) $raw;
        }

        $raw = trim((string) $raw);

        if (str_contains($raw, '/')) {
            [$num, $den] = explode('/', $raw, 2);

            $den = (float) $den;

            return $den != 0
                ? (float) $num / $den
                : 1.0;
        }

        $parsed = (float) $raw;

        return $parsed > 0
            ? $parsed
            : 1.0;
    }

    /**
     * Perhitungan AHP
     */
    private function hitungAHP(array $matrix, $kriterias): array
    {
        $n = count($matrix);

        // Jumlah kolom
        $colSum = array_fill(0, $n, 0.0);

        for ($j = 0; $j < $n; $j++) {
            for ($i = 0; $i < $n; $i++) {
                $colSum[$j] += $matrix[$i][$j];
            }
        }

        // Normalisasi
        $norm = [];

        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $norm[$i][$j] = $colSum[$j] > 0
                    ? $matrix[$i][$j] / $colSum[$j]
                    : 0.0;
            }
        }

        // Bobot prioritas
        $bobot   = [];
        $rowNorm = [];

        for ($i = 0; $i < $n; $i++) {
            $rowNorm[$i] = array_sum($norm[$i]);
            $bobot[$i]   = $rowNorm[$i] / $n;
        }

        // λmax
        $lambdaValues = [];
        $matTimesW    = [];

        for ($i = 0; $i < $n; $i++) {
            $sum = 0.0;

            for ($j = 0; $j < $n; $j++) {
                $sum += $matrix[$i][$j] * $bobot[$j];
            }

            $matTimesW[$i] = $sum;

            $lambdaValues[$i] = $bobot[$i] > 0
                ? $sum / $bobot[$i]
                : 0.0;
        }

        $lambdaMax = array_sum($lambdaValues) / $n;

        // CI
        $ci = $n > 1
            ? ($lambdaMax - $n) / ($n - 1)
            : 0.0;

        // CR
        $riVal = $this->ri[$n] ?? 1.49;

        $cr = $riVal > 0
            ? $ci / $riVal
            : 0.0;

        return [
            'matrix'       => $matrix,
            'colSum'       => $colSum,
            'norm'         => $norm,
            'rowNorm'      => $rowNorm,
            'bobot'        => $bobot,
            'matTimesW'    => $matTimesW,
            'lambdaValues' => $lambdaValues,
            'lambdaMax'    => $lambdaMax,
            'ci'           => $ci,
            'ri'           => $riVal,
            'cr'           => $cr,
            'consistent'   => $cr <= 0.10,
            'n'            => $n,
        ];
    }
}