<?php

namespace Database\Seeders;

use App\Models\Pencairan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PencairanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pencairan::factory(10)->create();
    }
}
