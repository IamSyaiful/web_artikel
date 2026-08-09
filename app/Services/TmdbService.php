<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TmdbService
{
    private function client(): PendingRequest
    {
        $token = config('services.tmdb.token');

        if (! $token) {
            throw new \RuntimeException('TMDB_API_TOKEN belum dikonfigurasi.');
        }

        return Http::withToken($token)
            ->acceptJson()
            ->timeout(15)
            ->baseUrl(config('services.tmdb.base_url'));
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function searchMovies(string $query): array
    {
        $response = $this->client()->get('/search/movie', [
            'query' => $query,
            'include_adult' => false,
            'language' => 'en-US',
            'page' => 1,
        ])->throw();

        return collect($response->json('results', []))
            ->take(8)
            ->map(fn (array $movie): array => [
                'id' => $movie['id'],
                'title' => $movie['title'] ?? '',
                'release_date' => $movie['release_date'] ?? null,
                'overview' => $movie['overview'] ?? '',
                'poster_path' => $movie['poster_path'] ?? null,
                'poster_url' => $this->posterUrl($movie['poster_path'] ?? null),
            ])
            ->values()
            ->all();
    }

    /**
     * @return array<string, mixed>
     */
    public function movieDetails(int $movieId): array
    {
        $movie = $this->client()->get("/movie/{$movieId}", [
            'append_to_response' => 'credits',
            'language' => 'en-US',
        ])->throw()->json();

        $director = collect(data_get($movie, 'credits.crew', []))
            ->firstWhere('job', 'Director');

        return [
            'id' => $movie['id'],
            'title' => $movie['title'] ?? '',
            'release_date' => $movie['release_date'] ?? null,
            'duration' => $movie['runtime'] ?? null,
            'director' => $director['name'] ?? null,
            'rating' => isset($movie['vote_average'])
                ? round(((float) $movie['vote_average']) / 2, 1)
                : 0,
            'synopsis' => $movie['overview'] ?? '',
            'poster_path' => $movie['poster_path'] ?? null,
            'poster_url' => $this->posterUrl($movie['poster_path'] ?? null),
            'genres' => collect($movie['genres'] ?? [])
                ->pluck('name')
                ->values()
                ->all(),
        ];
    }

    public function storePoster(string $posterPath): ?string
    {
        if (! Str::startsWith($posterPath, '/')) {
            return null;
        }

        $response = Http::timeout(20)->get($this->posterUrl($posterPath));

        if (! $response->successful()) {
            return null;
        }

        $extension = match ($response->header('Content-Type')) {
            'image/png' => 'png',
            'image/webp' => 'webp',
            default => 'jpg',
        };
        $path = 'movies/posters/tmdb-'.Str::uuid().'.'.$extension;

        Storage::disk('public')->put($path, $response->body());

        return $path;
    }

    private function posterUrl(?string $posterPath): ?string
    {
        return $posterPath
            ? rtrim(config('services.tmdb.image_url'), '/').'/'.ltrim($posterPath, '/')
            : null;
    }
}
