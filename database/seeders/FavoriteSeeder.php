<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Favorite;
use App\Models\User;
use App\Models\Movie;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $movies = Movie::all();

        $combinations = [];

        foreach ($users as $user) {
            foreach ($movies as $movie) {
                $combinations[] = [
                    'user_id' => $user->id,
                    'movie_id' => $movie->id,
                ];
            }
        }

        shuffle($combinations);

        $favorites = array_slice($combinations, 0, min(5, count($combinations)));

        Favorite::insert($favorites);

    }
}
