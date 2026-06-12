<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kriteria extends Model
{
    protected $table = 'kriterias';

    protected $fillable = [
        'kode',
        'nama',
        'tipe',
        'deskripsi',
        'urutan',
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];

    /* ─── Relasi ─── */

    public function subKriterias(): HasMany
    {
        return $this->hasMany(SubKriteria::class, 'kriteria_id')
                    ->orderByDesc('level'); // L4 → L1
    }

    /* ─── Accessor ─── */

    public function getTipeLabelAttribute(): string
    {
        return $this->tipe === 'benefit' ? 'Benefit' : 'Cost';
    }

    /* ─── Helper: generate kode otomatis ─── */

    public static function generateKode(): string
    {
        $existing = self::pluck('kode')->toArray();
        $i = 1;
        while (in_array('C' . $i, $existing)) {
            $i++;
        }
        return 'C' . $i;
    }

    /* ─── Helper: re-urut kode setelah delete ─── */

    public static function reorderKode(): void
    {
        $all = self::orderBy('urutan')->get();
        foreach ($all as $idx => $k) {
            $k->update(['kode' => 'C' . ($idx + 1), 'urutan' => $idx + 1]);
        }
    }
}
