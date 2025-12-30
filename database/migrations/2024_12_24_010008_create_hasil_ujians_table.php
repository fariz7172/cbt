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
        Schema::create('hasil_ujians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ujian_id')->constrained()->cascadeOnDelete();
            $table->foreignId('siswa_id')->constrained()->cascadeOnDelete();
            $table->datetime('waktu_mulai')->nullable();
            $table->datetime('waktu_selesai')->nullable();
            $table->decimal('nilai', 5, 2)->nullable();
            $table->integer('benar')->default(0);
            $table->integer('salah')->default(0);
            $table->enum('status', ['belum_mulai', 'sedang_mengerjakan', 'selesai'])->default('belum_mulai');
            $table->timestamps();
        });

        Schema::create('jawaban_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hasil_ujian_id')->constrained()->cascadeOnDelete();
            $table->foreignId('soal_id')->constrained()->cascadeOnDelete();
            $table->text('jawaban')->nullable();
            $table->boolean('is_benar')->nullable();
            $table->integer('poin_didapat')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_siswas');
        Schema::dropIfExists('hasil_ujians');
    }
};
