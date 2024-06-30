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
        Schema::table('sidis', function (Blueprint $table) {
            $table->dropColumn('catatan_sidi'); // Menghapus kolom catatan_sidi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sidis', function (Blueprint $table) {
            $table->text('catatan_sidi')->nullable(); // Menambahkan kembali kolom jika rollback (opsional)
        });
    }
};
