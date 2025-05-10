<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Media;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::all()->each(function (User $user) {
            // Create a single avatar per user
            Media::factory()
                ->for($user, 'mediaable')
                ->state(['collection_name' => 'avatar'])
                ->create();

            // Create 3 garde media items per user
            Media::factory()
                ->count(3)
                ->for($user, 'mediaable')
                ->state(['collection_name' => 'garde'])
                ->create();
        });
    }
}
