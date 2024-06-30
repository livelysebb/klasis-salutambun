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
        Schema::create('nikahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_jemaat_id')->constrained()->onDelete('cascade');
            $table->foreignId('pasangan_id')->constrained('anggota_jemaats')->onDelete('cascade'); // Relasi ke tabel anggota_jemaats
            $table->date('tanggal_nikah');
            $table->string('tempat_nikah');
            $table->string('pendeta_nikah');
            $table->text('catatan_nikah')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nikahs');
    }
};
