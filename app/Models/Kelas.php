<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'tingkat',
        'nama',
    ];

    /**
     * Get the rombels for this kelas.
     */
    public function rombels()
    {
        return $this->hasMany(Rombel::class);
    }

    /**
     * Get display name (e.g., "Kelas 1A")
     */
    public function getDisplayNameAttribute(): string
    {
        return "Kelas " . $this->nama;
    }
}
