<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\CountryCode;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
final class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /** @var CountryCode|null $countryCode */
        $countryCode = fake()->boolean(70) ? fake()->randomElement(CountryCode::cases()) : null;

        return [
            'name' => fake()->unique()->company,
            'website' => fake()->optional()->url,
            'country_code' => $countryCode?->value,
            'created_by' => User::factory(),
        ];
    }
}
