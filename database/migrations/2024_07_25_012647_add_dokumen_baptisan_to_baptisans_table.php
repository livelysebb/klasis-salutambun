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
        Schema::table('baptisans', function (Blueprint $table) {
            $table->string('dokumen_baptisan')->nullable(); // Menambahkan kolom dokumen_baptisan (nullable)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('baptisans', function (Blueprint $table) {
            $table->dropColumn('dokumen_baptisan'); // Menghapus kolom dokumen_baptisan
        });
    }
};
