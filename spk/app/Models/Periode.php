<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;

    protected $table = 'periodes';

    protected $fillable = [
        'nama_periode',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
    ];

    // Scope untuk periode aktif
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    // Accessor format tanggal Indonesia
    public function getTanggalFormatAttribute(): string
    {
        $bulan = [
            1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
            5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
            9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
        ];
        $mulai    = $this->tanggal_mulai->day.' '.$bulan[$this->tanggal_mulai->month].' '.$this->tanggal_mulai->year;
        $selesai  = $this->tanggal_selesai->day.' '.$bulan[$this->tanggal_selesai->month].' '.$this->tanggal_selesai->year;
        return $mulai.' - '.$selesai;
    }
}