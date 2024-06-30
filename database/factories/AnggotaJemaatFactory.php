<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Jemaat;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AnggotaJemaat>
 */
class AnggotaJemaatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jenisKelamin = $this->faker->randomElement(['Laki-laki', 'Perempuan']);
        $namaDepan = $this->faker->firstName($jenisKelamin);
        $namaBelakang = $this->faker->lastName;
        return [

            'jemaat_id' => Jemaat::inRandomOrder()->first()->id,
            'nama' => $namaDepan . ' ' . $namaBelakang, // Nama lengkap acak
            'jenis_kelamin' => $jenisKelamin,
            'tempat_lahir' => $this->faker->city, // Kota acak di Indonesia
            'tanggal_lahir' => $this->faker->dateTimeBetween('-60 years', '-18 years'), // Tanggal lahir antara 18-60 tahun yang lalu
            'nama_ayah' => $this->faker->name('male'), // Nama ayah acak
            'nama_ibu' => $this->faker->name('female'), // Nama ibu acak
        ];
    }
}
