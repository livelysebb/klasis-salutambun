<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\AnggotaJemaat;
use Carbon\Carbon;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Baptisan>
 */
class BaptisanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $anggotaJemaat = AnggotaJemaat::inRandomOrder()->first(); // Ambil anggota jemaat acak
        $tanggalLahir = Carbon::parse($anggotaJemaat->tanggal_lahir); // Tanggal lahir anggota jemaat

        return [
            'anggota_jemaat_id' => $anggotaJemaat->id,
            'tanggal_baptis' => $this->faker->dateTimeBetween($tanggalLahir, 'now'), // Tanggal baptisan acak setelah tanggal lahir
            'tempat_baptis' => $this->faker->city,
            'pendeta_baptis' => $this->faker->name,
            'daftar_saksi' => $this->faker->name() . ', ' . $this->faker->name(),
        ];
    }
}
