<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\BabysitterProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BabysitterProfile>
 */
class BabysitterProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BabysitterProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id'           => User::factory(),
            'first_name'        => $this->faker->firstName(),
            'last_name'         => $this->faker->lastName(),
            'birthdate'         => $this->faker->date(),
            'phone'             => $this->faker->phoneNumber(),
            'bio'               => $this->faker->paragraph(),
            'experience'        => $this->faker->paragraph(),
            'price_per_hour'    => $this->faker->numberBetween(10, 50),
            'payment_frequency' => $this->faker->randomElement([
                'per_task',
                'daily',
                'weekly',
                'biweekly',
                'monthly'
            ]),
        ];
    }
}
