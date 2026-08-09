<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Favorite;
use App\Models\User;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $sort = $request->query('sort', 'newest');
        $query = $user->favoritedMovies()->with('genres');

        match ($sort) {
            'oldest' => $query->orderBy('favorites.created_at'),
            'title' => $query->orderBy('movies.title'),
            default => $query->latest('favorites.created_at'),
        };

        $movies = $query->paginate(8)->withQueryString();

        return view('pages.user.favorites.index', [
            'movies' => $movies,
            'sort' => in_array($sort, ['newest', 'oldest', 'title'], true) ? $sort : 'newest',
        ]);
    }

    public function store(Movie $movie)
    {
        $user = auth()->user();

        if ($user->favoritedMovies()->where('movie_id', $movie->id)->exists()) {
            return back()->with('error', 'Movie is already in your favorites.');
        }

        $user->favoritedMovies()->attach($movie->id);

        return back()->with('success', 'Movie added to favorites.');
    }

    public function destroy(Movie $movie)
    {
        $user = auth()->user();

        $user->favoritedMovies()->detach($movie->id);

        return back()->with('success', 'Movie removed from favorites.');
    }
}
