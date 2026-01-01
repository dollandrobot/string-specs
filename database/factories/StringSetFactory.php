<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StringSet>
 */
final class StringSetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brand_id' => Brand::factory(),
            'name' => fake()->word,
            'product_code' => fake()->optional()->bothify('??-#####'),
            'winding_length' => fake()->optional()->numberBetween(100, 6000),
            'number_of_strings' => fake()->optional()->randomElement([4, 5, 6]),
            'highest_string_gauge' => fake()->optional()->randomElement([8, 9, 10, 11]),
            'lowest_string_gauge' => fake()->optional()->randomElement([42, 46, 48, 52, 54]),
            'created_by' => User::factory(),
        ];
    }
}
