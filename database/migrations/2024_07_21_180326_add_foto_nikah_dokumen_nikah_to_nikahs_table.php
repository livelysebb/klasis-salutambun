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
        Schema::table('nikahs', function (Blueprint $table) {
            $table->string('foto_nikah')->nullable()->after('catatan_nikah');
            $table->string('dokumen_nikah')->nullable()->after('foto_nikah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nikahs', function (Blueprint $table) {
            $table->dropColumn(['foto_nikah', 'dokumen_nikah']);
        });
    }
};
