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
        Schema::create('transaksi_keuangans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jemaat_id')->constrained()->onDelete('cascade');
            $table->enum('jenis_transaksi', ['pemasukan', 'pengeluaran']);
            $table->decimal('jumlah', 10, 2); // 10 digit total, 2 digit desimal
            $table->date('tanggal_transaksi');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_keuangans');
    }
};
