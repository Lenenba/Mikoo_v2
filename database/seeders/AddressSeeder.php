<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\ParentProfile;
use Illuminate\Database\Seeder;
use App\Models\BabysitterProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create one address for each parent profile
        ParentProfile::all()->each(function (ParentProfile $parent) {
            Address::factory()
                ->for($parent, 'addressable')
                ->create();
        });

        // Create one address for each babysitter profile
        BabysitterProfile::all()->each(function (BabysitterProfile $babysitter) {
            Address::factory()
                ->for($babysitter, 'addressable')
                ->create();
        });
    }
}
