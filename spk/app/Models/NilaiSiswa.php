<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NilaiSiswa extends Model
{
    use HasFactory;

    protected $table = 'nilai_siswas';

    protected $fillable = [
        'siswa_id',
        'sub_kriteria_id',
        'periode_id',
        'nilai',
    ];

    protected $casts = [
        'nilai' => 'integer',
    ];

    // ======================== RELATIONSHIPS ========================

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function subKriteria()
    {
        return $this->belongsTo(SubKriteria::class);
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    // ======================== ACCESSORS ========================

    /**
     * Label nilai (1=Kurang, 2=Cukup, 3=Baik, 4=Sangat Baik).
     */
    public function getNilaiLabelAttribute(): string
    {
        return match ($this->nilai) {
            1 => 'Kurang',
            2 => 'Cukup',
            3 => 'Baik',
            4 => 'Sangat Baik',
            default => '-',
        };
    }

    /**
     * Warna badge berdasarkan nilai.
     */
    public function getNilaiColorAttribute(): string
    {
        return match ($this->nilai) {
            1 => 'danger',
            2 => 'warning',
            3 => 'info',
            4 => 'success',
            default => 'secondary',
        };
    }
}