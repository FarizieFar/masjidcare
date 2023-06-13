<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengurusMasjidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::factory(40)->create();

        for($i = 1; $i <= 40; $i++){
            $user = User::find($i+1);
            $user->masjid_id = $i;
            $user->save();
        }
    }
}
