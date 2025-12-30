<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    use HasFactory;

    protected $fillable = [
        'guru_id',
        'pelajaran_id',
        'rombel_id',
        'judul',
        'deskripsi',
        'jenis',
        'waktu_mulai',
        'waktu_selesai',
        'durasi',
        'acak_soal',
        'acak_opsi',
        'tampil_nilai',
        'status',
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'durasi' => 'integer',
        'acak_soal' => 'boolean',
        'acak_opsi' => 'boolean',
        'tampil_nilai' => 'boolean',
    ];

    /**
     * Get the guru who created this ujian.
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    /**
     * Get the pelajaran for this ujian.
     */
    public function pelajaran()
    {
        return $this->belongsTo(Pelajaran::class);
    }

    /**
     * Get the rombel for this ujian.
     */
    public function rombel()
    {
        return $this->belongsTo(Rombel::class);
    }

    /**
     * Get soals for this ujian.
     */
    public function soals()
    {
        return $this->belongsToMany(Soal::class, 'ujian_soal')
            ->withPivot('urutan')
            ->orderByPivot('urutan');
    }

    /**
     * Get hasil ujians for this ujian.
     */
    public function hasilUjians()
    {
        return $this->hasMany(HasilUjian::class);
    }

    /**
     * Get jenis label.
     */
    public function getJenisLabelAttribute(): string
    {
        return match($this->jenis) {
            'ulangan_harian' => 'Ulangan Harian',
            'uts' => 'UTS',
            'uas' => 'UAS',
            'try_out' => 'Try Out',
            default => $this->jenis,
        };
    }

    /**
     * Get status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'draft' => 'Draft',
            'published' => 'Dipublikasikan',
            'ongoing' => 'Sedang Berlangsung',
            'finished' => 'Selesai',
            default => $this->status,
        };
    }

    /**
     * Check if ujian is currently active.
     */
    public function isActive(): bool
    {
        $now = now();
        return $this->status === 'published' 
            && $now->gte($this->waktu_mulai) 
            && $now->lte($this->waktu_selesai);
    }

    /**
     * Get total poin from all soals.
     */
    public function getTotalPoinAttribute(): int
    {
        return $this->soals->sum('poin');
    }

    /**
     * Scope for published ujians.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope for active (ongoing) ujians.
     */
    public function scopeActive($query)
    {
        $now = now();
        return $query->where('status', 'published')
            ->where('waktu_mulai', '<=', $now)
            ->where('waktu_selesai', '>=', $now);
    }
}
