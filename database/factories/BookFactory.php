<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use app\Models\Publisher;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'publisher_id' => Publisher::factory(),
            'title' => fake()->word(),
            'isbn' => fake()->isbn10(),
            'bibliography' => 'placeholder text',
            'cover' => fake()->imageUrl(),
            'price' => fake()->randomFloat(2, 7.50, 35.75),
        ];
    }
}
