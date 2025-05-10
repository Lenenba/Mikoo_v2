<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\ParentProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'addressable_id'   => ParentProfile::factory(),          // Link to a ParentProfile by default
            'addressable_type' => ParentProfile::class,             // Polymorphic type
            'street'           => $this->faker->streetAddress(),
            'city'             => $this->faker->city(),
            'province'         => $this->faker->stateAbbr(),
            'postal_code'      => $this->faker->postcode(),
            'country'          => $this->faker->country(),
            'latitude'         => $this->faker->latitude(),
            'longitude'        => $this->faker->longitude(),
        ];
    }
}
