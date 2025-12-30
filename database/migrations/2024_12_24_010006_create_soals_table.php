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
        Schema::create('soals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelajaran_id')->constrained()->cascadeOnDelete();
            $table->foreignId('guru_id')->constrained()->cascadeOnDelete();
            $table->integer('tingkat_kelas'); // 1-6
            $table->enum('tipe', ['pilihan_ganda', 'essay', 'benar_salah']);
            $table->text('pertanyaan');
            $table->json('opsi')->nullable(); // For pilihan ganda: ["A. ...", "B. ...", ...]
            $table->text('kunci_jawaban');
            $table->integer('poin')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soals');
    }
};
