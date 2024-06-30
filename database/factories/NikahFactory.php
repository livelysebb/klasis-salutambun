<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\AnggotaJemaat;
use App\Models\Sidi;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Nikah>
 */
class NikahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $anggotaJemaatIds = AnggotaJemaat::pluck('id')->toArray();

        return [
            'anggota_jemaat_id' => $this->faker->randomElement($anggotaJemaatIds),
            'pasangan_id' => $this->faker->randomElement($anggotaJemaatIds),
            'tanggal_nikah' => $this->faker->date(),
            'tempat_nikah' => $this->faker->city(),
            'pendeta_nikah' => $this->faker->name(),
            'catatan_nikah' => $this->faker->paragraph(), // Menghapus kolom status_pernikahan
        ];
    }
}
