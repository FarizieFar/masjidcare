<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Masjid>
 */
class MasjidFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                'nama' => fake()->unique()->word(1),
                'alamat' => fake()->address(),
                'luas' => mt_rand(1, 50),
                'surat' => 'tes',
                'foto' => fake()->imageUrl(640, 480, 'animals', true),
                'request' => fake()->randomElement(['approved','pending', 'declined']),
        ];
    }
}
