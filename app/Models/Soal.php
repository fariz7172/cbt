<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelajaran_id',
        'guru_id',
        'tingkat_kelas',
        'tipe',
        'pertanyaan',
        'gambar',
        'opsi',
        'kunci_jawaban',
        'poin',
    ];

    protected $casts = [
        'opsi' => 'array',
        'poin' => 'integer',
    ];

    /**
     * Get the pelajaran for this soal.
     */
    public function pelajaran()
    {
        return $this->belongsTo(Pelajaran::class);
    }

    /**
     * Get the guru who created this soal.
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    /**
     * Get ujians that use this soal.
     */
    public function ujians()
    {
        return $this->belongsToMany(Ujian::class, 'ujian_soal')
            ->withPivot('urutan');
    }

    /**
     * Get jawaban siswas for this soal.
     */
    public function jawabanSiswas()
    {
        return $this->hasMany(JawabanSiswa::class);
    }

    /**
     * Get tipe label.
     */
    public function getTipeLabelAttribute(): string
    {
        return match($this->tipe) {
            'pilihan_ganda' => 'Pilihan Ganda',
            'essay' => 'Essay',
            'benar_salah' => 'Benar/Salah',
            default => $this->tipe,
        };
    }

    /**
     * Check if soal is multiple choice.
     */
    public function isPilihanGanda(): bool
    {
        return $this->tipe === 'pilihan_ganda';
    }

    /**
     * Check if soal is essay.
     */
    public function isEssay(): bool
    {
        return $this->tipe === 'essay';
    }

    /**
     * Check if soal is true/false.
     */
    public function isBenarSalah(): bool
    {
        return $this->tipe === 'benar_salah';
    }
}
