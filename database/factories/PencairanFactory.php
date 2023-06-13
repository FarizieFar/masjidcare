<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pencairan>
 */
class PencairanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'masjid_id' => '1',
            'nominal' => mt_rand(10000, 30000),
            'tanggal' => fake()->dateTime(),
            'status' => fake()->randomElement(['Approved','Pending', 'Declined']),
            'pdf_laporan' => 'surat_masjid/DSiuRDKO3XZJpuJKN46cH56FkUj9vZYezy0aw4Ud.pdf'
        ];
    }
}
