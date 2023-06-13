<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donasi>
 */
class DonasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'masjid_id' => 1,
            'user_id' => mt_rand(2,3),
            'nominal' => mt_rand(10000, 300000),
            'status' => fake()->randomElement(['Approved','Pending', 'Declined']),
            'isAnonim' => fake()->randomElement(['True', 'False']),
            'isProcessed' => fake()->randomElement(['True', 'False']),
            'tanggal' => fake()->dateTime(),
            'metode_id' => mt_rand(1, 6)
        ];
    }
}
