<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre;
use Illuminate\Support\Str;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            'Action',
            'Adventure',
            'Animation',
            'Comedy',
            'Crime',
            'Drama',
            'Fantasy',
            'Horror',
            'Romance',
            'Sci-Fi',
            'Thriller',
        ];

        foreach ($genres as $genre) {
            Genre::create([
                'name' => $genre,
                'slug' => Str::slug($genre),
            ]);
        }
    }
}
