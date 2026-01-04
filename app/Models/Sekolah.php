<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nsm',
        'alamat',
        'telepon',
        'email',
        'logo',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get users for this sekolah.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get kelas for this sekolah.
     */
    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    /**
     * Get pelajarans for this sekolah.
     */
    public function pelajarans()
    {
        return $this->hasMany(Pelajaran::class);
    }

    /**
     * Get gurus for this sekolah.
     */
    public function gurus()
    {
        return $this->hasMany(Guru::class);
    }

    /**
     * Get siswas for this sekolah.
     */
    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }
}
