<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Movie;
use Illuminate\Support\Str;
use App\Models\Genre;
use App\Models\User;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authorId = User::where('role', 'admin')->value('id');

        $movies = [
            [
                'title' => 'Interstellar',
                'release_date' => '2014-11-07',
                'duration' => 169,
                'director' => 'Christopher Nolan',
                'rating' => 4.8,
                'synopsis' => 'Sebuah perjalanan luar angkasa untuk mencari tempat baru bagi umat manusia ketika kondisi Bumi semakin tidak memungkinkan untuk ditinggali.',
                'review' => 'Interstellar menawarkan perpaduan antara fiksi ilmiah, drama keluarga, dan perjalanan luar angkasa dengan visual yang mengesankan.',
                'genres' => ['Sci-Fi', 'Drama', 'Adventure'],
            ],
            [
                'title' => 'The Batman',
                'release_date' => '2022-03-04',
                'duration' => 176,
                'director' => 'Matt Reeves',
                'rating' => 4.5,
                'synopsis' => 'Batman menghadapi kasus pembunuhan misterius yang membawanya menyelidiki korupsi dan kejahatan di Gotham City.',
                'review' => 'The Batman menghadirkan pendekatan yang lebih gelap dan detektif terhadap karakter Batman dengan atmosfer Gotham yang kuat.',
                'genres' => ['Action', 'Crime', 'Drama', 'Thriller'],
            ],
        ];

        foreach ($movies as $movieData) {
            $genres = $movieData['genres'];

            unset($movieData['genres']);

            $movie = Movie::create([
                ...$movieData,
                'slug' => Str::slug($movieData['title']),
                'user_id' => $authorId,
                'status' => Movie::STATUS_APPROVED,
            ]);

            $genreIds = Genre::whereIn('name', $genres)
                ->pluck('id');

            $movie->genres()->attach($genreIds);
        }
    }
}
