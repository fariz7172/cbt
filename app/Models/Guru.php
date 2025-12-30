<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nip',
        'nama',
        'jabatan',
        'no_hp',
        'alamat',
        'foto',
    ];

    /**
     * Get the user that owns the guru.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get rombels where this guru is wali kelas.
     */
    public function rombelWaliKelas()
    {
        return $this->hasMany(Rombel::class, 'wali_kelas_id');
    }

    /**
     * Get rombels where this guru teaches.
     */
    public function rombels()
    {
        return $this->belongsToMany(Rombel::class, 'rombel_pelajaran')
            ->withPivot('pelajaran_id');
    }

    /**
     * Get pelajarans this guru teaches.
     */
    public function pelajarans()
    {
        return $this->belongsToMany(Pelajaran::class, 'rombel_pelajaran')
            ->withPivot('rombel_id');
    }

    /**
     * Get soals created by this guru.
     */
    public function soals()
    {
        return $this->hasMany(Soal::class);
    }

    /**
     * Get ujians created by this guru.
     */
    public function ujians()
    {
        return $this->hasMany(Ujian::class);
    }

    /**
     * Check if guru is kepala madrasah.
     */
    public function isKepalaMadrasah(): bool
    {
        return $this->jabatan === 'kepala_madrasah';
    }

    /**
     * Check if guru is guru kelas.
     */
    public function isGuruKelas(): bool
    {
        return $this->jabatan === 'guru_kelas';
    }

    /**
     * Check if guru is guru mapel.
     */
    public function isGuruMapel(): bool
    {
        return $this->jabatan === 'guru_mapel';
    }

    /**
     * Get jabatan label.
     */
    public function getJabatanLabelAttribute(): string
    {
        return match($this->jabatan) {
            'kepala_madrasah' => 'Kepala Madrasah',
            'guru_kelas' => 'Guru Kelas',
            'guru_mapel' => 'Guru Mata Pelajaran',
            default => $this->jabatan,
        };
    }
}
