<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Symfony\Component\String\TruncateMode;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookRequest>
 */
class BookRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_id' => Book::factory(),
            'user_id' => User::factory(),
            'requestDate' => Carbon::today()->format('Y-m-d'),
            'requestEndDate' => Carbon::today()->addDays(5)->format('Y-m-d'),
            'returnedDate' => null,
            'completed' => false,
        ];
    }

    public function completed()
    {
        return $this->state(function () {
            return [
                'completed' => true,
                'returnedDate' => Carbon::now(),
            ];
        });
    }
}
