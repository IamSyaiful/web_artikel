<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Page;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $yearRules = ['nullable', 'integer', 'between:1900,' . now()->year];
        $yearFromRules = $yearRules;

        if ($request->filled('year_to')) {
            $yearFromRules[] = 'lte:year_to';
        }

        $validated = $request->validate([
            'year_from' => $yearFromRules,
            'year_to' => $yearRules,
        ], [
            'year_from.lte' => 'The starting year must not be later than the ending year.',
        ]);

        $query = Movie::approved()->with('genres');

        // Fungsi Search

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('title', 'like', '%' . $search . '%');
        }

        // Filter Genre (by slug)

        if ($request->filled('genre')) {

            $slug = $request->genre;

            $query->whereHas('genres', function ($genreQuery) use ($slug) {

                $genreQuery->where('genres.slug', $slug);

            });
        }

        // Filter Rating

        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->rating);
        }

        // Filter Year

        if (! empty($validated['year_from'])) {
            $query->whereYear('release_date', '>=', $validated['year_from']);
        }

        if (! empty($validated['year_to'])) {
            $query->whereYear('release_date', '<=', $validated['year_to']);
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
        if ($movie->status !== Movie::STATUS_APPROVED) {
            abort(404);
        }

        $movie->load([
            'author',
            'genres',
            'comments' => function ($query) {
                $query
                    ->with('user')
                    ->latest();
            },
        ]);

        $genreIds = $movie->genres->pluck('id');

        $relatedMovies = Movie::approved()
            ->with('genres')
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

            $additionalMovies = Movie::approved()
                ->with('genres')
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

    public function destroy(Request $request, Movie $movie): RedirectResponse
    {
        if ($movie->user_id !== $request->user()->id) {
            abort(403, 'You can only delete your own approved movie.');
        }

        if ($movie->poster) {
            Storage::disk('public')->delete($movie->poster);
        }

        $movie->delete();

        return redirect()->route('submissions.index')
            ->with('success', 'Movie yang sudah disetujui berhasil dihapus.');
    }
}
