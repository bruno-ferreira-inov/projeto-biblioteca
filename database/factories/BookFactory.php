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
        $quantity = fake()->randomNumber(1);

        return [
            'publisher_id' => Publisher::factory(),
            'title' => fake()->unique()->word(),
            'isbn' => fake()->unique()->isbn13(),
            'bibliography' => 'placeholder text',
            'cover' => fake()->imageUrl(),
            'price' => fake()->randomFloat(2, 7.50, 35.75),
            'total_quantity' => $quantity,
            'current_quantity' => $quantity,
        ];
    }
}
