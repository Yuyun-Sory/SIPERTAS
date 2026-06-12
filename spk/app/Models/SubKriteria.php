<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubKriteria extends Model
{
    protected $table = 'sub_kriterias';

    protected $fillable = [
        'kriteria_id',
        'level',
        'nama',
        'deskripsi',
    ];

    protected $casts = [
        'level' => 'integer',
    ];

    /* ─── Relasi ─── */

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }

    /* ─── Accessor: level class untuk Blade ─── */

    public function getLevelClassAttribute(): string
    {
        return match ($this->level) {
            4 => 'l4',
            3 => 'l3',
            2 => 'l2',
            default => 'l1',
        };
    }

    public function getLevelColorAttribute(): string
    {
        return match ($this->level) {
            4 => 'green',
            3 => 'blue',
            2 => 'yellow',
            default => 'red',
        };
    }

    public function getLevelBadgeBgAttribute(): string
    {
        return match ($this->level) {
            4 => '#f0fdf4',
            3 => '#eff6ff',
            2 => '#fefce8',
            default => '#fff1f2',
        };
    }

    public function getLevelBadgeTextAttribute(): string
    {
        return match ($this->level) {
            4 => '#16a34a',
            3 => '#2563eb',
            2 => '#ca8a04',
            default => '#e11d48',
        };
    }
}
