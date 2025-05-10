<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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
        // Try to get a random profile photo URL; fallback to a placeholder logo.
        $url = $this->generateFakeProfilePhoto() ?? $this->generateFakeCompanyLogo2();

        // Derive a file name from the URL path, or generate a uuid if none.
        $pathInfo = pathinfo(parse_url($url, PHP_URL_PATH) ?? '');
        $fileName = isset($pathInfo['basename']) && Str::contains($pathInfo['basename'], '.')
            ? $pathInfo['basename']
            : (Str::uuid() . '.jpg');

        return [
            // Attach to a new user by default
            'mediaable_id'    => User::factory(),
            'mediaable_type'  => User::class,
            // Default collection; adjust via state() when needed
            'collection_name' => 'avatar',
            'file_name'       => $fileName,
            // We store the remote URL directly
            'file_path'       => $url,
            'mime_type'       => 'image/jpeg',
            'size'            => $this->faker->numberBetween(10_000, 500_000),
        ];
    }

    /**
     * Generate a fake profile photo URL from Unsplash.
     *
     * @return string|null
     */
    private function generateFakeProfilePhoto(): ?string
    {
        if (!env('UNSPLASH_ACCESS_KEY')) {
            return null;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Client-ID ' . env('UNSPLASH_ACCESS_KEY'),
            ])->get('https://api.unsplash.com/photos/random', [
                'query'       => 'portrait',
                'orientation' => 'squarish',
            ]);

            if ($response->successful()) {
                return $response->json('urls.regular');
            }
        } catch (\Throwable $e) {
            // silently ignore API errors
        }

        return null;
    }

    /**
     * Generate a fake company logo placeholder URL.
     *
     * @return string
     */
    private function generateFakeCompanyLogo2(): string
    {
        $bgColor = ltrim($this->faker->hexColor(), '#');
        $text    = strtoupper(substr($this->faker->company(), 0, 3));
        $width   = 150;
        $height  = 150;

        return "https://api.oneapipro.com/images/placeholder"
            . "?text={$text}&width={$width}&height={$height}&color={$bgColor}";
    }
}
