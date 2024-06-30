<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jemaat>
 */
class JemaatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->company, // Nama perusahaan acak
            'alamat' => $this->faker->streetAddress, // Alamat jalan acak
            'telepon' => $this->faker->phoneNumber, // Nomor telepon acak
            'email' => $this->faker->unique()->safeEmail, // Email acak yang unik dan valid
        ];
    }
}
