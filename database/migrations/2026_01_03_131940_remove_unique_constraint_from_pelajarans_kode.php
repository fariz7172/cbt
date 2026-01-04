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
        Schema::table('pelajarans', function (Blueprint $table) {
            // Drop the unique constraint on kode column
            $table->dropUnique('pelajarans_kode_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelajarans', function (Blueprint $table) {
            // Re-add the unique constraint
            $table->unique('kode');
        });
    }
};
