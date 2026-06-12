<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';

    protected $fillable = [
        'nis',
        'nama',
        'kelas',
        'jenis_kelamin',
        'foto',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ======================== RELATIONSHIPS ========================

    /**
     * Satu siswa memiliki banyak nilai (di berbagai periode).
     */
    public function nilaiSiswas()
    {
        return $this->hasMany(NilaiSiswa::class);
    }

    /**
     * Nilai siswa untuk periode tertentu.
     */
    public function nilaiPeriode($periodeId)
    {
        return $this->hasMany(NilaiSiswa::class)
                    ->where('periode_id', $periodeId)
                    ->with('subKriteria.kriteria');
    }

    // ======================== ACCESSORS ========================

    /**
     * Inisial nama untuk avatar.
     */
    public function getInitialsAttribute(): string
    {
        $words = explode(' ', trim($this->nama));
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($this->nama, 0, 2));
    }

    /**
     * Label jenis kelamin.
     */
    public function getJenisKelaminLabelAttribute(): string
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    // ======================== SCOPES ========================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByKelas($query, string $kelas)
    {
        return $query->where('kelas', $kelas);
    }

    public function scopeSearch($query, string $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('nama', 'like', "%{$keyword}%")
              ->orWhere('nis', 'like', "%{$keyword}%")
              ->orWhere('kelas', 'like', "%{$keyword}%");
        });
    }
}