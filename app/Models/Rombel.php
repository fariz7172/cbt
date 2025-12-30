<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    use HasFactory;

    protected $fillable = [
        'kelas_id',
        'wali_kelas_id',
        'tahun_ajaran',
        'semester',
    ];

    /**
     * Get the kelas for this rombel.
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * Get the wali kelas (guru kelas) for this rombel.
     */
    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id');
    }

    /**
     * Get siswas in this rombel.
     */
    public function siswas()
    {
        return $this->belongsToMany(Siswa::class, 'rombel_siswa');
    }

    /**
     * Get pelajarans for this rombel.
     */
    public function pelajarans()
    {
        return $this->belongsToMany(Pelajaran::class, 'rombel_pelajaran')
            ->withPivot('guru_id');
    }

    /**
     * Get gurus teaching in this rombel.
     */
    public function gurus()
    {
        return $this->belongsToMany(Guru::class, 'rombel_pelajaran')
            ->withPivot('pelajaran_id');
    }

    /**
     * Get ujians for this rombel.
     */
    public function ujians()
    {
        return $this->hasMany(Ujian::class);
    }

    /**
     * Get display name (e.g., "Kelas 1A - TA 2024/2025 Ganjil")
     */
    public function getDisplayNameAttribute(): string
    {
        return "Kelas " . $this->kelas->nama . " - TA " . $this->tahun_ajaran . " " . ucfirst($this->semester);
    }

    /**
     * Scope for current tahun ajaran.
     */
    public function scopeCurrentYear($query, $tahunAjaran = null)
    {
        $tahunAjaran = $tahunAjaran ?? date('Y') . '/' . (date('Y') + 1);
        return $query->where('tahun_ajaran', $tahunAjaran);
    }
}
