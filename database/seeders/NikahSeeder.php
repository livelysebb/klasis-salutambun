<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Nikah;

class NikahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Hapus data pernikahan sebelumnya (opsional)
        // DB::table('nikahs')->truncate();

        // Buat 30 data pernikahan dummy
        Nikah::factory()
            ->count(50) // Atau sesuaikan jumlah data yang ingin dibuat
            ->create();
    }
}
