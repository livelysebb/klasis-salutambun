<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AnggotaJemaat;
class AnggotaJemaatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data anggota jemaat sebelumnya (opsional)
        // AnggotaJemaat::truncate();

        // Buat 50 data anggota jemaat dummy
        AnggotaJemaat::factory()->count(50)->create();
    }
}
