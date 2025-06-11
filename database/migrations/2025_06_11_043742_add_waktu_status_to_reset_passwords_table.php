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
    Schema::table('reset_passwords', function (Blueprint $table) {
        if (!Schema::hasColumn('reset_passwords', 'waktu_permohonan')) {
            $table->time('waktu_permohonan')->nullable();
        }

        if (!Schema::hasColumn('reset_passwords', 'status')) {
            $table->enum('status', ['Proses', 'Selesai', 'Gagal'])->default('Proses');
        }
    });
}

    /**
     * Reverse the migrations.
     */
   public function down(): void
{
    Schema::table('reset_passwords', function (Blueprint $table) {
        $table->dropColumn('waktu_permohonan');
        $table->dropColumn('status');
    });
}
};
