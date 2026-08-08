<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Movie;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->value('id'),
            'movie_id' => Movie::query()->inRandomOrder()->value('id'),
            'comment' => fake()->paragraph(),
        ];
    }
}
