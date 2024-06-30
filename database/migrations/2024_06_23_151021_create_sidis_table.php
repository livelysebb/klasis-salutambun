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
        Schema::create('sidis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_jemaat_id')->constrained()->onDelete('cascade');
            $table->date('tanggal_sidi');
            $table->string('tempat_sidi');
            $table->string('pendeta_sidi');
            $table->string('bacaan_sidi');
            $table->text('catatan_sidi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sidis');
    }
};
