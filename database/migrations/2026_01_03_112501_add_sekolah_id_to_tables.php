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
        // Add sekolah_id to users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('sekolah_id')->nullable()->after('role')->constrained('sekolahs')->nullOnDelete();
        });

        // Add sekolah_id to kelas table
        Schema::table('kelas', function (Blueprint $table) {
            $table->foreignId('sekolah_id')->nullable()->after('nama')->constrained('sekolahs')->cascadeOnDelete();
        });

        // Add sekolah_id to pelajarans table
        Schema::table('pelajarans', function (Blueprint $table) {
            $table->foreignId('sekolah_id')->nullable()->after('jenis')->constrained('sekolahs')->cascadeOnDelete();
        });

        // Add sekolah_id to gurus table
        Schema::table('gurus', function (Blueprint $table) {
            $table->foreignId('sekolah_id')->nullable()->after('user_id')->constrained('sekolahs')->cascadeOnDelete();
        });

        // Add sekolah_id to siswas table
        Schema::table('siswas', function (Blueprint $table) {
            $table->foreignId('sekolah_id')->nullable()->after('user_id')->constrained('sekolahs')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropForeign(['sekolah_id']);
            $table->dropColumn('sekolah_id');
        });

        Schema::table('gurus', function (Blueprint $table) {
            $table->dropForeign(['sekolah_id']);
            $table->dropColumn('sekolah_id');
        });

        Schema::table('pelajarans', function (Blueprint $table) {
            $table->dropForeign(['sekolah_id']);
            $table->dropColumn('sekolah_id');
        });

        Schema::table('kelas', function (Blueprint $table) {
            $table->dropForeign(['sekolah_id']);
            $table->dropColumn('sekolah_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['sekolah_id']);
            $table->dropColumn('sekolah_id');
        });
    }
};
