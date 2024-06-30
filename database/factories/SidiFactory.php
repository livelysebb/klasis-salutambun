<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\AnggotaJemaat;
use App\Models\Sidi;
use Carbon\Carbon;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sidi>
 */
class SidiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $anggotaJemaat = AnggotaJemaat::inRandomOrder()->first();
        $tanggalLahir = Carbon::parse($anggotaJemaat->tanggal_lahir);
        return [
            'anggota_jemaat_id' => $anggotaJemaat->id,
            'tanggal_sidi' => $this->faker->dateTimeBetween($tanggalLahir->addYears(17), 'now'), // 17 tahun setelah tanggal lahir
            'tempat_sidi' => $this->faker->city,
            'pendeta_sidi' => $this->faker->name,
            'bacaan_sidi' => $this->faker->sentence,
            'nomor_surat' => $this->faker->unique()->bothify('SIDI-####-??'),
        ];
    }
}
