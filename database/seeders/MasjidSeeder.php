<?php

namespace Database\Seeders;

use App\Models\Masjid;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasjidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Masjid::factory(40)->create();
        
    }
}
