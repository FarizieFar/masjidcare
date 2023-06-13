<?php

namespace Database\Seeders;

use App\Models\Nominal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NominalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nominal' => 15000
            ],
            [
                'nominal' => 20000
            ],
            [
                'nominal' => 25000
            ],
            [
                'nominal' => 30000
            ],
            [
                'nominal' => 35000
            ],
            [
                'nominal' => 40000
            ],
            [
                'nominal' => 45000
            ],
            [
                'nominal' => 50000
            ],
            [
                'nominal' => 100000
            ],
            [
                'nominal' => 500000
            ],
            [
                'nominal' => 1000000
            ]
        ];
        Nominal::insert($data);
    }
}
