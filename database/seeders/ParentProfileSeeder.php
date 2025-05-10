<?php

namespace Database\Seeders;

use App\Models\ParentProfile;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ParentProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ParentProfile::factory()
            ->count(10)
            ->create();
    }
}
