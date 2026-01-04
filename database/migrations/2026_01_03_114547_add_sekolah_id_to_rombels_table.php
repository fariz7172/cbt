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
        Schema::table('rombels', function (Blueprint $table) {
            $table->foreignId('sekolah_id')->nullable()->after('id')->constrained('sekolahs')->cascadeOnDelete();
        });

        // Update existing rombels to get sekolah_id from their kelas
        DB::statement('
            UPDATE rombels r
            INNER JOIN kelas k ON r.kelas_id = k.id
            SET r.sekolah_id = k.sekolah_id
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rombels', function (Blueprint $table) {
            $table->dropForeign(['sekolah_id']);
            $table->dropColumn('sekolah_id');
        });
    }
};
