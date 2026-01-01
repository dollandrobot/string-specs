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
            'brand_id' => Brand::inRandomOrder()->first()->id ?? Brand::factory(),
            'name' => fake()->word,
            'product_code' => fake()->optional()->bothify('??-#####'),
            'winding_length' => fake()->optional()->numberBetween(10000, 60000),
            'number_of_strings' => fake()->optional()->randomElement([4, 5, 6]),
            'high_gauge' => fake()->optional()->randomElement([40, 45, 50, 52, 54, 56]),
            'low_gauge' => fake()->optional()->randomElement([90, 95, 100, 105, 110, 115]),
            'created_by' => User::factory(),
        ];
    }
}
