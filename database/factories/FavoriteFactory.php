<?php

namespace Database\Factories;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Movie;

/**
 * @extends Factory<Favorite>
 */
class FavoriteFactory extends Factory
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
        ];
    }
}
