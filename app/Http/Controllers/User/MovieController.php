<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Page;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $query = Movie::with('genres');

        // Fungsi Search

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('title', 'like', '%' . $search . '%');
        }

        // Filter Genre

        if ($request->filled('genre')) {

            $genreId = $request->genre;

            $query->whereHas('genres', function ($genreQuery) use ($genreId) {

                $genreQuery->where('genres.id', $genreId);

            });
        }

        // Filter Rating

        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->rating);
        }

        // Filter Year

        if ($request->filled('year_from')) {
            $query->whereYear('release_date', '>=', $request->year_from);
        }

        if ($request->filled('year_to')) {
            $query->whereYear('release_date', '<=', $request->year_to);
        }

        //Sorting

        switch ($request->sort) {

            case 'rating':
                $query->orderByDesc('rating');
                break;

            case 'oldest':
                $query->orderBy('release_date');
                break;

            case 'newest':
                $query->orderByDesc('release_date');
                break;

            case 'title':
                $query->orderBy('title');
                break;

            default:
                $query->orderByDesc('rating');
                break;
        }


        // Pagination

        $movies = $query
            ->paginate(12)
            ->withQueryString();

        // Genre

        $genres = Genre::withCount('movies')
            ->orderBy('name')
            ->get();

        $moviesContent = Page::where('slug', 'movies')
            ->with('contents')
            ->first()?->contents
            ->pluck('value', 'key') ?? collect();


        return view('pages.user.movies.index', [
            'movies' => $movies,
            'genres' => $genres,
            'moviesContent' => $moviesContent,
        ]);
    }

    public function show(Movie $movie)
    {
        $movie->load([
            'genres',
            'comments' => function ($query) {
                $query
                    ->with('user')
                    ->latest();
            },
        ]);

        $genreIds = $movie->genres->pluck('id');

        $relatedMovies = Movie::with('genres')
            ->where('id', '!=', $movie->id)
            ->when(
                $genreIds->isNotEmpty(),
                function ($query) use ($genreIds) {
                    $query->whereHas('genres', function ($genreQuery) use ($genreIds) {
                        $genreQuery->whereIn('genres.id', $genreIds);
                    });
                }
            )
            ->latest()
            ->take(5)
            ->get();

        // Jika film dengan genre yang sama kurang dari 5,
        // tambahkan film terbaru lainnya
        if ($relatedMovies->count() < 5) {

            $additionalMovies = Movie::with('genres')
                ->where('id', '!=', $movie->id)
                ->whereNotIn('id', $relatedMovies->pluck('id'))
                ->latest()
                ->take(5 - $relatedMovies->count())
                ->get();

            $relatedMovies = $relatedMovies->concat($additionalMovies);
        }

        $isFavorite = false;

        if (auth()->check()) {
            $isFavorite = auth()->user()
                ->favoritedMovies()
                ->where('movie_id', $movie->id)
                ->exists();
        }

        return view('pages.user.movies.show', [
            'movie' => $movie,
            'relatedMovies' => $relatedMovies,
            'isFavorite' => $isFavorite,
        ]);

    }
}
