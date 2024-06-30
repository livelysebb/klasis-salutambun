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
        Schema::create('baptisans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_jemaat_id')->constrained()->onDelete('cascade');
            $table->date('tanggal_baptis');
            $table->string('tempat_baptis');
            $table->text('daftar_saksi');
            $table->string('pendeta_baptis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baptisans');
    }
};
