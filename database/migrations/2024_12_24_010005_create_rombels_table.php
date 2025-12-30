<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rombels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->foreignId('wali_kelas_id')->constrained('gurus');
            $table->string('tahun_ajaran'); // 2024/2025
            $table->enum('semester', ['ganjil', 'genap']);
            $table->timestamps();
        });

        // Pivot: Rombel - Siswa
        Schema::create('rombel_siswa', function (Blueprint $table) {
            $table->foreignId('rombel_id')->constrained()->cascadeOnDelete();
            $table->foreignId('siswa_id')->constrained()->cascadeOnDelete();
            $table->primary(['rombel_id', 'siswa_id']);
        });

        // Pivot: Rombel - Pelajaran - Guru
        Schema::create('rombel_pelajaran', function (Blueprint $table) {
            $table->foreignId('rombel_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pelajaran_id')->constrained()->cascadeOnDelete();
            $table->foreignId('guru_id')->constrained()->cascadeOnDelete();
            $table->primary(['rombel_id', 'pelajaran_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rombel_pelajaran');
        Schema::dropIfExists('rombel_siswa');
        Schema::dropIfExists('rombels');
    }
};
