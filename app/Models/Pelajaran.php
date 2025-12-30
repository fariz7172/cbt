<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelajaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'jenis',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get soals for this pelajaran.
     */
    public function soals()
    {
        return $this->hasMany(Soal::class);
    }

    /**
     * Get ujians for this pelajaran.
     */
    public function ujians()
    {
        return $this->hasMany(Ujian::class);
    }

    /**
     * Get rombels that have this pelajaran.
     */
    public function rombels()
    {
        return $this->belongsToMany(Rombel::class, 'rombel_pelajaran')
            ->withPivot('guru_id');
    }

    /**
     * Get gurus teaching this pelajaran.
     */
    public function gurus()
    {
        return $this->belongsToMany(Guru::class, 'rombel_pelajaran')
            ->withPivot('rombel_id');
    }

    /**
     * Get jenis label.
     */
    public function getJenisLabelAttribute(): string
    {
        return $this->jenis === 'guru_kelas' ? 'Pelajaran Guru Kelas' : 'Pelajaran Guru Mapel';
    }
}
