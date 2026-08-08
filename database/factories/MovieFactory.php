<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(3);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'poster' => null,
            'release_date' => fake()->date(),
            'duration' => fake()->numberBetween(80, 180),
            'director' => fake()->name(),
            'rating' => fake()->randomFloat(1, 0, 5),
            'synopsis' => fake()->paragraph(),
            'review' => fake()->paragraphs(3, true),
        ];
    }
}
