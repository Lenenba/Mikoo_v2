<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BabysitterProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BabysitterProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BabysitterProfile::factory()
            ->count(10)
            ->create();
    }
}
