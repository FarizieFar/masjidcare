<?php

namespace Database\Seeders;

use App\Models\MetodePembayaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MetodePembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'BCA',
                'nomor' => '302859478246'
            ],
            [
                'nama' => 'BNI',
                'nomor' => '302859478546'
            ],
            [
                'nama' => 'BRI',
                'nomor' => '302859472246'
            ],
            [
                'nama' => 'Mandiri',
                'nomor' => '302859478636'
            ],
            [
                'nama' => 'BSI',
                'nomor' => '302876478246'
            ],
            [
                'nama' => 'BTN',
                'nomor' => '302859478436'
            ]
            ];
        MetodePembayaran::insert($data);
    }
}
