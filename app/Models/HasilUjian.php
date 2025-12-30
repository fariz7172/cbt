<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilUjian extends Model
{
    use HasFactory;

    protected $fillable = [
        'ujian_id',
        'siswa_id',
        'waktu_mulai',
        'waktu_selesai',
        'nilai',
        'benar',
        'salah',
        'status',
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'nilai' => 'decimal:2',
        'benar' => 'integer',
        'salah' => 'integer',
    ];

    /**
     * Get the ujian for this hasil.
     */
    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }

    /**
     * Get the siswa for this hasil.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * Get jawaban siswas for this hasil.
     */
    public function jawabanSiswas()
    {
        return $this->hasMany(JawabanSiswa::class);
    }

    /**
     * Get status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'belum_mulai' => 'Belum Mulai',
            'sedang_mengerjakan' => 'Sedang Mengerjakan',
            'selesai' => 'Selesai',
            default => $this->status,
        };
    }

    /**
     * Get durasi pengerjaan in minutes.
     */
    public function getDurasiPengerjaanAttribute(): ?int
    {
        if (!$this->waktu_mulai || !$this->waktu_selesai) {
            return null;
        }
        return $this->waktu_mulai->diffInMinutes($this->waktu_selesai);
    }

    /**
     * Calculate and update nilai.
     */
    public function calculateNilai(): void
    {
        $totalPoin = $this->ujian->total_poin;
        $poinDidapat = $this->jawabanSiswas->sum('poin_didapat');
        
        $this->nilai = $totalPoin > 0 ? ($poinDidapat / $totalPoin) * 100 : 0;
        $this->benar = $this->jawabanSiswas->where('is_benar', true)->count();
        $this->salah = $this->jawabanSiswas->where('is_benar', false)->count();
        $this->save();
    }

    /**
     * Check if this exam has essay questions.
     */
    public function hasEssayQuestions(): bool
    {
        return $this->ujian->soals()->where('tipe', 'essay')->exists();
    }

    /**
     * Get count of essay questions that need grading.
     */
    public function getUngradedEssayCount(): int
    {
        return $this->jawabanSiswas()
            ->whereHas('soal', function ($query) {
                $query->where('tipe', 'essay');
            })
            ->whereNull('is_benar')
            ->count();
    }

    /**
     * Get total essay questions count.
     */
    public function getTotalEssayCount(): int
    {
        return $this->jawabanSiswas()
            ->whereHas('soal', function ($query) {
                $query->where('tipe', 'essay');
            })
            ->count();
    }

    /**
     * Check if all essay questions have been graded.
     */
    public function isGradingComplete(): bool
    {
        if (!$this->hasEssayQuestions()) {
            return true; // No essay = grading complete
        }
        return $this->getUngradedEssayCount() === 0;
    }

    /**
     * Get grading status label.
     */
    public function getGradingStatusAttribute(): string
    {
        if (!$this->hasEssayQuestions()) {
            return 'complete';
        }
        
        $ungraded = $this->getUngradedEssayCount();
        $total = $this->getTotalEssayCount();
        
        if ($ungraded === $total) {
            return 'pending';
        } elseif ($ungraded > 0) {
            return 'partial';
        }
        return 'complete';
    }
}
