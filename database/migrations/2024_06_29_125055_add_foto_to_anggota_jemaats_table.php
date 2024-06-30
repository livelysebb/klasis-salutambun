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
        Schema::table('anggota_jemaats', function (Blueprint $table) {
            $table->string('foto')->nullable(); // Menambahkan kolom foto dengan tipe data string dan nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anggota_jemaats', function (Blueprint $table) {
            $table->dropColumn('foto'); // Menghapus kolom foto jika rollback
        });
    }
};
