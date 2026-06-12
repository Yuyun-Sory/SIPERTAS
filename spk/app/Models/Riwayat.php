<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Riwayat extends Model
{
    protected $table = 'riwayats';

    protected $fillable = [
        'jenis',
        'periode_id',
        'user_id',
        'judul',
        'keterangan',
        'siswa_ids',  // ← tambahan: array ID siswa yang dihitung
        'data_json',
    ];

    protected $casts = [
        'siswa_ids' => 'array',  // ← tambahan: otomatis encode/decode JSON
        'data_json' => 'array',
    ];

    // ── Relasi ──────────────────────────────────────────────────

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Accessor ────────────────────────────────────────────────

    public function getJenisLabelAttribute(): string
    {
        return match($this->jenis) {
            'smart' => 'Perhitungan SMART',
            'ahp'   => 'Perhitungan AHP',
            'nilai' => 'Input Nilai',
            default => ucfirst($this->jenis),
        };
    }

    public function getJenisIconAttribute(): string
    {
        return match($this->jenis) {
            'smart' => '🏆',
            'ahp'   => '⚖️',
            'nilai' => '📝',
            default => '📋',
        };
    }

    public function getJenisBadgeClassAttribute(): string
    {
        return match($this->jenis) {
            'smart' => 'badge-smart',
            'ahp'   => 'badge-ahp',
            'nilai' => 'badge-nilai',
            default => 'badge-default',
        };
    }
}