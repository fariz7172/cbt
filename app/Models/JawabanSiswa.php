<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanSiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'hasil_ujian_id',
        'soal_id',
        'jawaban',
        'is_benar',
        'poin_didapat',
    ];

    protected $casts = [
        'is_benar' => 'boolean',
        'poin_didapat' => 'integer',
    ];

    /**
     * Get the hasil ujian for this jawaban.
     */
    public function hasilUjian()
    {
        return $this->belongsTo(HasilUjian::class);
    }

    /**
     * Get the soal for this jawaban.
     */
    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }

    /**
     * Check and grade the jawaban (for pilihan ganda & benar_salah).
     */
    public function grade(): void
    {
        $soal = $this->soal;
        
        if ($soal->isEssay()) {
            // Essay requires manual grading
            return;
        }

        // For pilihan ganda and benar_salah
        $this->is_benar = strtolower(trim($this->jawaban)) === strtolower(trim($soal->kunci_jawaban));
        $this->poin_didapat = $this->is_benar ? $soal->poin : 0;
        $this->save();
    }
}
