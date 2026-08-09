<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Genre;

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


        return view('pages.user.movies.index', [
            'movies' => $movies,
            'genres' => $genres,
        ]);
    }

    public function show(Movie $movie)
    {
        $movie->load('genres', 'comments.user');

        // Ambil ID genre dari movie saat ini
        $genreIds = $movie->genres->pluck('id');

        // Ambil film terkait berdasarkan genre
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

        return view('pages.user.movies.show', [
            'movie' => $movie,
            'relatedMovies' => $relatedMovies,
        ]);

    }
}
