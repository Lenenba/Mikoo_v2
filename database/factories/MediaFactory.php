<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Media::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $fileName = $this->faker->lexify('file_????.jpg');

        return [
            'mediaable_id'   => User::factory(),
            'mediaable_type' => User::class,
            'collection_name' => 'avatar',
            'file_name'      => $fileName,
            'file_path'      => 'avatars/' . $fileName,
            'mime_type'      => 'image/jpeg',
            'size'           => $this->faker->numberBetween(1000, 500000),
        ];
    }
}
