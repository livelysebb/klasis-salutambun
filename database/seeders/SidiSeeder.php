<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sidi;

class SidiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus semua data sidi yang ada
        Sidi::truncate();

        // Buat 30 data sidi dummy menggunakan factory
        Sidi::factory()
            ->count(30)
            ->create();
    }
}
