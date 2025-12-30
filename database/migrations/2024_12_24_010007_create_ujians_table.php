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
        Schema::create('ujians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pelajaran_id')->constrained()->cascadeOnDelete();
            $table->foreignId('rombel_id')->constrained()->cascadeOnDelete();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->enum('jenis', ['ulangan_harian', 'uts', 'uas', 'try_out']);
            $table->datetime('waktu_mulai');
            $table->datetime('waktu_selesai');
            $table->integer('durasi'); // in minutes
            $table->boolean('acak_soal')->default(false);
            $table->boolean('acak_opsi')->default(false);
            $table->boolean('tampil_nilai')->default(true);
            $table->enum('status', ['draft', 'published', 'ongoing', 'finished'])->default('draft');
            $table->timestamps();
        });

        // Pivot: Ujian - Soal
        Schema::create('ujian_soal', function (Blueprint $table) {
            $table->foreignId('ujian_id')->constrained()->cascadeOnDelete();
            $table->foreignId('soal_id')->constrained()->cascadeOnDelete();
            $table->integer('urutan')->default(0);
            $table->primary(['ujian_id', 'soal_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujian_soal');
        Schema::dropIfExists('ujians');
    }
};
