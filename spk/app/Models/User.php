<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'kelas',   
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            // 'email_verified_at' => 'datetime', ← hapus, kolom ini tidak ada di migration
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Helper role check
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isWaliKelas(): bool // ← ganti dari isGuru()
    {
        return $this->role === 'wali_kelas';
    }

    public function isKepalaSekolah(): bool
    {
        return $this->role === 'kepala_sekolah';
    }
}