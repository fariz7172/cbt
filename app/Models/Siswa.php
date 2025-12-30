<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kelas_id',
        'nisn',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'alamat',
        'no_hp_ortu',
        'foto',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Get the user that owns the siswa.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the kelas this siswa belongs to.
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * Get rombels this siswa belongs to.
     */
    public function rombels()
    {
        return $this->belongsToMany(Rombel::class, 'rombel_siswa');
    }

    /**
     * Get the current rombel (latest tahun ajaran).
     */
    public function currentRombel()
    {
        return $this->rombels()
            ->orderByDesc('tahun_ajaran')
            ->orderByDesc('semester')
            ->first();
    }

    /**
     * Get hasil ujians for this siswa.
     */
    public function hasilUjians()
    {
        return $this->hasMany(HasilUjian::class);
    }

    /**
     * Get jenis kelamin label.
     */
    public function getJenisKelaminLabelAttribute(): string
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }
}
