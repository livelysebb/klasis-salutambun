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
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->string('perihal');
            $table->enum('jenis_surat', ['masuk', 'keluar']);
            $table->string('pengirim_tujuan'); // Bisa pengirim atau tujuan
            $table->string('penerima')->nullable(); // Hanya untuk surat masuk
            $table->string('file_surat')->nullable(); // Path file surat
            $table->timestamps();
            $table->foreignId('jemaat_id')->nullable()->constrained()->onDelete('set null'); // Mengubah foreign menjadi foreignId
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};
